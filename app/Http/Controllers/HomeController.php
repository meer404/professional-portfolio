<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'featuredProjects' => Project::featured()->ordered()->with('media')->get(),
            'hasMoreProjects' => Project::count() > Project::featured()->count(),
            'skillGroups' => Skill::ordered()->get()->groupBy('category'),
            'clients' => Client::active()->ordered()->get(),
        ]);
    }
}
