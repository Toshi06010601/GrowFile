<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Str;

class ProfileSearchController extends Controller
{
    public function show(Request $request)
    {
        $search = strtolower($request->search);

        $profiles = Profile::whereRaw('LOWER(full_name) LIKE ?', $search . '%')
                    ->select('id', 'full_name', 'profile_image_path', 'background_image_path', 'headline', 'location', 'bio', 'slug')
                    ->orderBy('full_name')
                    ->get();
        return view('profile_search', compact('profiles'));
    }
}
