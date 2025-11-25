<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $projects = $request->user()->projects()->latest()->get();
        return view('dashboard', compact('projects'));
    }
}
