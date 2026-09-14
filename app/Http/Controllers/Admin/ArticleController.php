<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::when(request('search'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when(request('status'), fn ($q, $s) => $q->where('status', $s))
            ->when(request('category'), fn ($q, $c) => $q->where('category', $c))
            ->orderByDesc('is_pinned')->latest()->paginate(10)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);
        $data['user_id'] = auth()->id();
        $data['is_pinned'] = $request->boolean('is_pinned');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['title'] ?? $article->title, $article->id);
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($article->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $data['is_pinned'] = $request->boolean('is_pinned');

        if ($data['status'] === 'published' && empty($article->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        Storage::disk('public')->delete($article->thumbnail);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: Str::random(8);
        $slug = $base;
        $i = 2;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
