<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\HeroPhoto;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'projects' => Project::count(),
                'articles' => Article::count(),
                'draftArticles' => Article::where('status', 'draft')->count(),
                'staff' => Staff::count(),
                'heroPhotos' => HeroPhoto::count(),
                'partners' => Partner::count(),
            ],
            'latestProjects' => Project::latest()->take(5)->get(),
            'latestArticles' => Article::latest()->take(5)->get(),
        ]);
    }
}
