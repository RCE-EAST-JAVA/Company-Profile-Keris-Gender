<?php

namespace App\Http\Controllers;

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
        $category = request('category');

        $people = Staff::query()
            ->when($category && $category !== 'all', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('People/Index', [
            'people' => $people,
            'currentCategory' => $category ?: 'all',
            'categoryCounts' => [
                'all' => Staff::count(),
                'Researcher' => Staff::where('category', 'Researcher')->count(),
                'Research Assistant' => Staff::where('category', 'Research Assistant')->count(),
            ],
        ]);
    }

    /**
     * Display a specific scholar detail.
     */
    public function show(Staff $staff): Response
    {
        return Inertia::render('People/Show', [
            'staff' => $staff,
        ]);
    }
}
