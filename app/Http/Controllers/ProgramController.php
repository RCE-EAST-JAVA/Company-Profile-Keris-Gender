<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs and research initiatives.
     */
    public function index(): Response
    {
        $featuredPrograms = Project::with('projectImages')
            ->where('is_pinned', true)
            ->orderBy('id')
            ->get();

        $initiatives = Project::with('projectImages')
            ->orderByDesc('is_pinned')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('Programs/Index', [
            'featuredPrograms' => $featuredPrograms,
            'initiatives' => $initiatives,
        ]);
    }

    /**
     * Display a specific program detail.
     */
    public function show(Project $project): Response
    {
        $project->load(['projectImages', 'user']);

        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('id', '!=', $project->id)
                ->take(3)
                ->get();
        }

        return Inertia::render('Programs/Show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
