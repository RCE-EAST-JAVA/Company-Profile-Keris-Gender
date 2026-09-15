@extends('layouts.admin')
@section('title', 'Articles')

@section('content')
@include('components.page-header', ['title' => 'Articles', 'eyebrow' => 'Research Archive', 'action' => route('admin.articles.create'), 'actionLabel' => 'Tulis Artikel'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b border-gray-200 p-5">
        <input name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="min-w-52 flex-1 rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <select name="status" class="rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            <option value="">Semua status</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
        </select>
        <input name="category" value="{{ request('category') }}" placeholder="Kategori" class="rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <button class="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">
                <tr><th class="px-4 py-3 font-medium">Judul</th><th class="px-4 py-3 font-medium">Kategori</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3 text-right font-medium">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($articles as $article)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($article->thumbnail)
                                    <img src="{{ $article->thumbnail }}" class="h-10 w-14 rounded-xl object-cover" alt="">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $article->title }} @if($article->is_pinned)<span class="ml-1 rounded-full bg-gray-900 px-2 py-0.5 font-mono text-[10px] uppercase tracking-wider text-white">Pinned</span>@endif</p>
                                    <p class="font-mono text-xs text-gray-400">
                                        /{{ $article->slug }}
                                        @if ($article->published_at)
                                            • <span class="text-gray-500">{{ $article->published_at->format('d M Y, H:i') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 font-medium text-xs">{{ $article->category }}</td>
                        <td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 font-mono text-[11px] uppercase tracking-wider {{ $article->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600' }}">{{ $article->status }}</span></td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-full bg-red-50 px-4 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-gray-200 p-4">{{ $articles->links() }}</div>
</div>
@endsection
