<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicationController extends Controller
{
    /**
     * Display a listing of publications with search and filters.
     */
    public function index(Request $request): Response
    {
        $category = $request->query('category', 'all');
        $search = $request->query('search', '');

        $query = Article::where('status', 'published');

        if ($category !== 'all' && !empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderByDesc('published_at')->get();

        $featured = Article::where('is_pinned', true)
            ->where('category', 'Book & Module')
            ->first() ?? Article::latest('published_at')->first();

        $categoryCounts = [
            'all' => Article::where('status', 'published')->count(),
            'Journal Article' => Article::where('status', 'published')->where('category', 'Journal Article')->count(),
            'Book & Module' => Article::where('status', 'published')->where('category', 'Book & Module')->count(),
            'Policy Brief' => Article::where('status', 'published')->where('category', 'Policy Brief')->count(),
            'Annual Report' => Article::where('status', 'published')->where('category', 'Annual Report')->count(),
        ];

        return Inertia::render('Publications/Index', [
            'articles' => $articles,
            'featured' => $featured,
            'filters' => [
                'category' => $category,
                'search' => $search,
            ],
            'categoryCounts' => $categoryCounts,
        ]);
    }

    /**
     * Display a specific publication detail.
     */
    public function show(string $slug): Response
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $authorStaff = null;
        if ($article->author) {
            $authorKeywords = ['Amanda', 'Hendra', 'Kartika', 'Farhan', 'Nadia', 'Dian'];
            foreach ($authorKeywords as $kw) {
                if (stripos($article->author, $kw) !== false) {
                    $authorStaff = Staff::where('name', 'like', "%{$kw}%")->first();
                    if ($authorStaff) break;
                }
            }
        }

        $relatedArticles = Article::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->where('category', $article->category)
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $extra = Article::where('id', '!=', $article->id)
                ->where('status', 'published')
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->concat($extra);
        }

        return Inertia::render('Publications/Show', [
            'article' => $article,
            'authorStaff' => $authorStaff,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
