<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Staff;
use Inertia\Inertia;
use Inertia\Response;

class PeopleController extends Controller
{
    /**
     * Display a listing of research staff and scholars.
     */
    public function index(): Response
    {
        $principalInvestigators = Staff::where('category', 'Researcher')
            ->orderBy('sort_order')
            ->get();

        $researchAssistants = Staff::where('category', 'Research Assistant')
            ->orderBy('sort_order')
            ->get();

        $allStaff = Staff::orderBy('sort_order')->get();

        return Inertia::render('People/Index', [
            'principalInvestigators' => $principalInvestigators,
            'researchAssistants' => $researchAssistants,
            'allStaff' => $allStaff,
        ]);
    }

    /**
     * Display a specific scholar detail and their authored articles.
     */
    public function show(Staff $staff): Response
    {
        $firstName = explode(' ', str_replace(['Prof.', 'Dr.', 'Dra.', 'S.H.', 'LL.M.', 'Ph.D.', 'M.Sc.', 'M.A.', 'S.Sos.', ','], '', $staff->name))[0] ?? '';
        $firstName = trim($firstName);

        $publications = Article::where('status', 'published')
            ->where(function ($query) use ($staff, $firstName) {
                $query->where('author', 'like', "%{$staff->name}%")
                    ->orWhere('author', 'like', "%{$firstName}%");
            })
            ->orderByDesc('published_at')
            ->get();

        $otherStaff = Staff::where('id', '!=', $staff->id)
            ->where('category', $staff->category)
            ->take(3)
            ->get();

        return Inertia::render('People/Show', [
            'staff' => $staff,
            'publications' => $publications,
            'otherStaff' => $otherStaff,
        ]);
    }
}
