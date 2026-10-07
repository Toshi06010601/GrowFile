<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Profile;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ProfessionalProfile\IndexRequest;
use App\Http\UseCases\ProfessionalProfile\IndexAction;

/**
 * Lists, creates and displays professional profiles.
 */
class ProfessionalProfileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show a searchable, paginated list of public profiles.
     *
     * Filters (all optional, validated by IndexRequest):
     * - name, location: prefix match, case-insensitive
     * - skill[]:        profile's user must have ALL selected skills
     * - following:      only users the current user follows
     * - followed:       only users who follow the current user
     *
     * Hidden profiles and the current user's own profile are always excluded.
     */

    public function index(IndexRequest $request): View
    {
        // 0. Validate input values
        $validated = $request->validated();

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

    
    /**
     * Show the profile creation form, or redirect to the existing profile.
     * Each user can have only one profile.
     */
    public function create(): View|RedirectResponse
    {
         // Check if user already has a profile
        if (Auth::user()->profile()->exists()) {
            return redirect()->route('professional_profile.show', Auth::user()->profile->slug);
        }

        return view('professional_profile.create');
    }

    /**
     * Create the user's profile with placeholder values and redirect to it.
     *
     * Only the name is collected here. The profile starts hidden (visibility
     * false) so it isn't public until the user fills it in and publishes it.
     * The slug is a UUID, so profile URLs can't be guessed from the name.
     */
    public function store(Request $request): RedirectResponse
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

        return redirect(route('professional_profile.show', ['profile' => $slug]));
    }

  /**
     * Show a profile, resolved from its slug by route model binding.
     *
     * Visible only if the profile is public or belongs to the current user;
     * otherwise the visitor is sent back to the index.
     *
     * @param  string   $locale  Locale URL prefix. Unused here, but it must stay
     *                           in the signature because it is the first route parameter.
     * @param  Profile  $slug    The profile matching the {slug} route parameter.
     */
    public function show(string $locale, Profile $slug): View|RedirectResponse
    {
        // Navigate to profile page if visibility is true or the user is profile owner
        if($slug->visibility || $slug->user_id === Auth::id()) {
            return view('professional_profile.show', ['profile' => $slug]);
        } else {
            return redirect(route('professional_profile.index'));
        }
    }

}
