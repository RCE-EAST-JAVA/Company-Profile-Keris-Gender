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
     * Display a listing of publications with search and separated tabs.
     */
    public function index(Request $request): Response
    {
        $category = $request->query('category');
        $tab = $request->query('tab');

        if (! $tab && $category) {
            if (stripos($category, 'Book') !== false || stripos($category, 'Module') !== false) {
                $tab = 'book';
            } else {
                $tab = 'journal';
            }
        }
        $tab = $tab ?: 'journal';

        $search = $request->query('search', '');

        $journalQuery = Article::where('status', 'published')
            ->where(function ($q) {
                $q->where('category', 'Journal Article')
                    ->orWhere('category', 'Policy Brief')
                    ->orWhere('category', 'Annual Report');
            });

        $bookQuery = Article::where('status', 'published')
            ->where('category', 'Book & Module');

        if (! empty($search)) {
            $searchFilter = function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            };
            $journalQuery->where($searchFilter);
            $bookQuery->where($searchFilter);
        }

        $journalArticles = $journalQuery->orderByDesc('published_at')->get();
        $bookModules = $bookQuery->orderByDesc('published_at')->get();
        $allArticles = Article::where('status', 'published')->orderByDesc('published_at')->get();

        return Inertia::render('Publications/Index', [
            'articles' => $allArticles,
            'journalArticles' => $journalArticles,
            'bookModules' => $bookModules,
            'journalCount' => $journalArticles->count(),
            'bookCount' => $bookModules->count(),
            'categoryCounts' => [
                'all' => $allArticles->count(),
                'Journal Article' => $journalArticles->count(),
                'Book & Module' => $bookModules->count(),
            ],
            'filters' => [
                'tab' => $tab,
                'search' => $search,
            ],
        ]);
    }

    /**
     * Display a specific publication detail.
     */
    public function show(string $slug): Response
    {
        $article = Article::where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $authorStaff = null;
        if ($article->author) {
            $authorKeywords = ['Amanda', 'Hendra', 'Kartika', 'Farhan', 'Nadia', 'Dian'];
            foreach ($authorKeywords as $kw) {
                if (stripos($article->author, $kw) !== false) {
                    $authorStaff = Staff::where('name', 'like', "%{$kw}%")->first();
                    if ($authorStaff) {
                        break;
                    }
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
