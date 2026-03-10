<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Builder;

class ProfessionalProfileController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // 0. Validate input values
        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'skill' => 'nullable|array|max:50',
            'skill.*' => 'integer|exists:skills,id',
            'following' => 'nullable|boolean',
            'followed' => 'nullable|boolean',
        ]);

        // 1. Get and sanitize input
        $name = str_replace(['%', '_'], ['\%', '\_'], strtolower($validated['name'] ?? ''));
        $location = str_replace(['%', '_'], ['\%', '\_'], strtolower($validated['location'] ?? ''));
        $following = $validated['following'] ?? false;
        $followed = $validated['followed'] ?? false;
        $selectedSkills = $validated['skill'] ?? [];

        // Start query on Profile model
        $profilesQuery = Profile::query();

        // 2. Apply name and location filters (wherelike automatically wrap with lower())
        $profilesQuery->whereLike('full_name', $name . '%')
                    ->whereLike('location', $location . '%');
                    
        // 3. Apply the "has ALL skills" filter (on the related User -> UserSkills)
        if (is_array($selectedSkills) && count($selectedSkills) > 0) {
            $skillCount = count($selectedSkills);

            $profilesQuery->whereHas('user', function (Builder $q) use ($selectedSkills, $skillCount) {
                
                // Check the related user's skills
                $q->whereHas('userSkills', function (Builder $qq) use ($selectedSkills) {
                    // Filter the skills to only include the ones selected
                    $qq->whereIn('skill_id', $selectedSkills);
                }, '=', $skillCount); // <--- Count must exactly match the number of selected skills
                
            });
        }

        // 4. Add following/followed filter if requested
        $profilesQuery->with(['user.authFollows', 'user.authFollowed']);

        if($following) {
            $profilesQuery
                ->has('user.authFollows');

        } elseif($followed) {
            $profilesQuery
                ->has('user.authFollowed');

        }

        // 5. Get profiles which match all the filter criterion
        $profiles = $profilesQuery
                ->select('id', 'full_name', 'profile_image_path', 'background_image_path', 'headline', 'location', 'bio', 'slug', 'user_id')
                ->where('visibility', true)
                ->where('user_id', '!=', Auth::id())
                ->orderBy('full_name')
                ->paginate(20);

        // 6. Get skills for filter options
        $groupedSkills = Skill::select('id', 'category', 'name')
                            ->get()
                            ->groupBy('category');

        return view('professional_profile.index', compact('profiles', 'groupedSkills', 'name', 'location', 'selectedSkills', 'following', 'followed'));
    }

    public function create()
    {
         // Check if user already has a profile
        if (Auth::user()->profile()->exists()) {
            return redirect()->route('professional_profile.show', Auth::user()->profile->slug);
        }

        return view('professional_profile.create');
    }

    public function store(Request $request)
    {
        // Check if user already has a profile
        if (Auth::user()->profile()->exists()) {
            return redirect()->route('professional_profile.show', Auth::user()->profile->slug);
        }

        // 1. Validate name
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
        ]);

        // 2. Construct full name and slug
        $slug = Str::uuid();

        // 3. Create profile with default information in other columns
        Profile::create([
            'user_id' => Auth::id(),
            'full_name' => $validated['full_name'],
            'slug' => $slug,
            'profile_image_path' => '/profile_photos/default.svg',
            'background_image_path' => '/background_photos/default.jpg',
            'headline' => '',
            'bio' => '',
            'job_status' => 'exploring',
            'visibility' => false,
            'location' => '',
            'github_link' => '',
            'linkedin_link' => '',
        ]);

        return redirect(route('professional_profile.show', ['slug' => $slug]));
    }

    // Get the selected profile based on slug
    public function show($locale, Profile $slug)
    {
        // Navigate to profile page if visibility is true or the user is profile owner
        if($slug->visibility || $slug->user_id === Auth::id()) {
            return view('professional_profile.show', ['profile' => $slug]);
        } else {
            return redirect(route('professional_profile.index'));
        }
    }

}
