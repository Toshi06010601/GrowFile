<?php

namespace App\UseCases\ProfessionalProfile;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class IndexAction
{
    public function __invoke(string $name, string $location, array $selectedSkills, bool $following, bool $followed): LengthAwarePaginator
    {
        $query = Profile::query();

        // Apply filters
        $this->applyNameFilter($query, $name);
        $this->applyLocationFilter($query, $location);
        $this->applySkillsFilter($query, $selectedSkills);
        $this->applyFollowFilter($query, $following, $followed);

        // Return paginated results
        return  $query
                ->select('id', 'full_name', 'profile_image_path', 'background_image_path', 'headline', 'location', 'bio', 'slug', 'user_id')
                ->where('visibility', true)
                ->where('user_id', '!=', Auth::id())
                ->orderBy('full_name')
                ->paginate(20);

    }

    /**
     * Apply name filter to query.
     */
    protected function applyNamefilter(Builder $query, string $name): void 
    {
        if(empty($name)) {
            return;
        }

        $query->whereLike('full_name', $name . '%');
    }

    /**
     * Apply location filter to query.
     */
    protected function applyLocationfilter(Builder $query, string $location): void 
    {
        if(empty($location)) {
            return;
        }

        $query->whereLike('location', $location . '%');
    }

    /**
     * Apply skills filter - user must have ALL selected skills.
     */
    protected function applySkillsfilter(Builder $query, array $selectedSkills): void 
    {
        if(empty($selectedSkills)) {
            return;
        }

        $skillCount = count($selectedSkills);

        // 3. Apply the "has ALL skills" filter (on the related User -> UserSkills)
        if (is_array($selectedSkills) && count($selectedSkills) > 0) {

            $profilesQuery->whereHas('user', function (Builder $q) use ($selectedSkills, $skillCount) {
                
                // Check the related user's skills
                $q->whereHas('userSkills', function (Builder $qq) use ($selectedSkills) {
                    // Filter the skills to only include the ones selected
                    $qq->whereIn('skill_id', $selectedSkills);
                }, '=', $skillCount); // <--- Count must exactly match the number of selected skills
                
            });
        }
    }

    /**
     * Apply follow filter to query.
     */
    protected function applyFollowfilter(Builder $query, bool $following, bool $followed): void 
    {
        $query->with(['user.authFollows', 'user.authFollowed']);

        if($following) {
            $query->has('user.authFollows');
        } elseif($followed) {
            $query->has('user.authFollowed');
        }
    }
}