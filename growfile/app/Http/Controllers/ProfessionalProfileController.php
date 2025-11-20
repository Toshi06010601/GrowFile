<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfessionalProfileController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $search = strtolower($request->input('search', ''));

        $profiles = Profile::whereRaw('LOWER(full_name) LIKE ?', $search . '%')
                    ->select('id', 'full_name', 'profile_image_path', 'background_image_path', 'headline', 'location', 'bio', 'slug')
                    ->orderBy('full_name')
                    ->get();
        return view('professional_profile_index', compact('profiles'));
    }

    public function create()
    {
        return view('professional_profile_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
        ]);

        $fullName = $request->first_name . " " . $request->last_name;
        $slug = Str::slug($fullName) . "-" . Str::uuid();

        Profile::create([
            'user_id' => Auth::id(),
            'full_name' => $fullName,
            'slug' => $slug,
            'profile_image_path' => 'storage/profile_photos/default.png',
            'background_image_path' => 'storage/background_photos/default.png',
            'headline' => 'Your role',
            'bio' => 'Your bio',
            'job_status' => 'exploring',
            'visibility' => false,
            'location' => 'Location',
            'github_link' => '',
            'linkedin_link' => '',
        ]);

        return redirect(route('professional_profile.edit', $slug));
    }

    public function show(Profile $slug)
    {
        return view('professional_profile', ['profile' => $slug]);
    }

    public function edit(Profile $slug)
    {
        $this->authorize('update', $slug);

        return view('professional_profile', ['profile' => $slug]);

    }

}
