<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessionalProfileController extends Controller
{
    public function show()
    {
        $userId = auth()->id();
        return view('professional_profile', compact('userId'));
    }
}
