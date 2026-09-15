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
        $request->merge(['tab' => $tab]);

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

        $applySorting = function ($query) {
            return $query->orderByDesc('is_pinned')
                ->orderByDesc('published_at');
        };

        $journalArticles = $tab === 'journal'
            ? $applySorting($journalQuery)->paginate(9)->withQueryString()
            : $applySorting($journalQuery)->paginate(9, ['*'], 'page', 1)->withQueryString();

        $bookModules = $tab === 'book'
            ? $applySorting($bookQuery)->paginate(9)->withQueryString()
            : $applySorting($bookQuery)->paginate(9, ['*'], 'page', 1)->withQueryString();

        return Inertia::render('Publications/Index', [
            'journalArticles' => $journalArticles,
            'bookModules' => $bookModules,
            'journalCount' => $journalArticles->total(),
            'bookCount' => $bookModules->total(),
            'categoryCounts' => [
                'all' => $journalArticles->total() + $bookModules->total(),
                'Journal Article' => $journalArticles->total(),
                'Book & Module' => $bookModules->total(),
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
