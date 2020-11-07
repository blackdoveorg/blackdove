<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeedController extends Controller
{
    // Controller for setting a user's Seed position.
    public function index()
    {
        return view('seed');
    }
}
