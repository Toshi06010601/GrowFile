<?php

namespace App\Http\Controllers;

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
        // 1. Get and sanitize input
        $name = strtolower($request->input('name', ''));
        $location = strtolower($request->input('location', ''));
        $following = $request->input('following');
        $followed = $request->input('followed');
        $selectedSkills = $request->input('skill');

        // Start query on Profile model
        $profilesQuery = Profile::query();

        // 2. Apply name and location filters
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
        $profilesQuery->with('user.authFollows')
                      ->with('user.authFollowed');

        if($following) {
            $profilesQuery
                ->Has('user.authFollows');

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
        return view('professional_profile.create');
    }

    public function store(Request $request)
    {
        // 1. Validate name
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
        ]);

        // 2. Construct full name and slug
        $fullName = $request->first_name . " " . $request->last_name;
        $slug = Str::slug($fullName) . "-" . Str::uuid();

        // 3. Create profile with default information in other columns
        Profile::create([
            'user_id' => Auth::id(),
            'full_name' => $fullName,
            'slug' => $slug,
            'profile_image_path' => '/storage/profile_photos/default.svg',
            'background_image_path' => '/storage/background_photos/default.jpg',
            'headline' => 'Your role',
            'bio' => 'Your bio',
            'job_status' => 'exploring',
            'visibility' => false,
            'location' => 'Location',
            'github_link' => '',
            'linkedin_link' => '',
        ]);

        return redirect(route('professional_profile.show', $slug));
    }

    // Get the selected profile based on slug
    public function show(Profile $slug)
    {
        // Navigate to profile page if visibility is true or the user is profile owner
        if($slug->visibility || $slug->user_id === Auth::id()) {
            return view('professional_profile.show', ['profile' => $slug]);
        } else {
            return redirect(route('professional_profile.index'));
        }
    }

}
