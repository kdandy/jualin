<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileUsahaController extends Controller
{
    /**
     * Display the about us page.
     */
    public function tentangKami()
    {
        return view('profile-usaha.tentang-kami');
    }
}