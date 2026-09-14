<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        $heroPhoto = HeroPhoto::where('is_active', true)->orderBy('order')->first();
        $partners = Partner::all();

        $featuredMonograph = Article::where('is_pinned', true)
            ->where('category', 'Book & Module')
            ->first() ?? Article::latest('published_at')->first();

        $recentPublications = Article::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        $stats = [
            'publications_count' => Article::where('status', 'published')->count() . '+',
            'partners_count' => Partner::count() . '+',
            'active_programs_count' => Project::where('status', 'Aktif')->count(),
            'scholars_count' => Staff::count(),
        ];

        return Inertia::render('Home', [
            'heroPhoto' => $heroPhoto,
            'partners' => $partners,
            'featuredMonograph' => $featuredMonograph,
            'recentPublications' => $recentPublications,
            'stats' => $stats,
        ]);
    }
}
