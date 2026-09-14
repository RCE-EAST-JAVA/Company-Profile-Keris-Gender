@extends('layouts.admin')
@section('title', 'Articles')

@section('content')
@include('components.page-header', ['title' => 'Articles', 'action' => route('admin.articles.create'), 'actionLabel' => 'Tulis Artikel'])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b p-4">
        <input name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="min-w-52 flex-1 rounded-lg border-gray-300 text-sm">
        <select name="status" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua status</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
        </select>
        <input name="category" value="{{ request('category') }}" placeholder="Kategori" class="rounded-lg border-gray-300 text-sm">
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr><th class="px-4 py-3">Judul</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($articles as $article)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="h-10 w-14 rounded object-cover" alt="">
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $article->title }} @if($article->is_pinned)<span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[10px] text-amber-700">PINNED</span>@endif</p>
                                    <p class="text-xs text-gray-500">/{{ $article->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $article->category }}</td>
                        <td class="px-4 py-3"><span class="rounded px-2 py-1 text-xs {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $article->status }}</span></td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t p-4">{{ $articles->links() }}</div>
</div>
@endsection
