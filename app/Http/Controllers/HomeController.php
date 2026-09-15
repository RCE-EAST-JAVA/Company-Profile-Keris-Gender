<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Article;
use App\Models\HeroBackground;
use App\Models\HeroPhoto;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Staff;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display the Home landing page.
     */
    public function index(): Response
    {
        $about = About::first();
        $heroPhotos = HeroPhoto::where('is_active', true)->orderBy('order')->get();
        $heroBackground = HeroBackground::where('is_active', true)->first();
        $partners = Partner::all();

        $featuredMonograph = Article::where('is_pinned', true)
            ->where('category', 'Book & Module')
            ->first() ?? Article::latest('published_at')->first();

        $recentPublications = Article::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        $recentPrograms = Project::with('projectImages')
            ->orderByDesc('is_pinned')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $stats = [
            'publications_count' => Article::where('status', 'published')->count().'+',
            'partners_count' => Partner::count().'+',
            'active_programs_count' => Project::where('status', 'Aktif')->count(),
            'scholars_count' => Staff::count(),
        ];

        return Inertia::render('Home', [
            'about' => $about,
            'heroPhotos' => $heroPhotos,
            'heroPhoto' => $heroPhotos->first(),
            'heroBackground' => $heroBackground,
            'partners' => $partners,
            'programs' => $recentPrograms,
            'featuredMonograph' => $featuredMonograph,
            'recentPublications' => $recentPublications,
            'stats' => $stats,
        ]);
    }
}
