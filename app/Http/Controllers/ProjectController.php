<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index', [
            'projects' => Project::ordered()->with('media')->get(),
        ]);
    }

    public function show(Project $project): View
    {
        $project->load('media');

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}
