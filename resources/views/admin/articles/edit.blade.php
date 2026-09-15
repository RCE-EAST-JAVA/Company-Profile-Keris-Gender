@extends('layouts.admin')
@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    @if ($article->thumbnail)
        <img src="{{ $article->thumbnail }}" class="mb-4 h-48 w-full rounded-xl object-cover" alt="">
    @endif
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf @method('PUT')
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Judul *</label><input name="title" value="{{ old('title', $article->title) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Slug</label><input name="slug" value="{{ old('slug', $article->slug) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Kategori Publikasi *</label>
            <select name="category" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                @php
                    $currentCat = old('category', $article->category);
                    $categories = ['Journal Article', 'Book & Module', 'Policy Brief', 'Annual Report', 'Opini & Analisis'];
                    if ($currentCat && !in_array($currentCat, $categories)) {
                        $categories[] = $currentCat;
                    }
                @endphp
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" @selected($currentCat === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Excerpt</label><textarea name="excerpt" rows="2" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">{{ old('excerpt', $article->excerpt) }}</textarea></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Body *</label><x-tiptap-editor name="body" :value="old('body', $article->body)" /></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Author</label><input name="author" value="{{ old('author', $article->author) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tags</label><input name="tags" value="{{ old('tags', $article->tags) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Status *</label>
            <select name="status" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="draft" @selected(old('status', $article->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $article->status) === 'published')>Published</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tanggal Upload / Publikasi</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            <p class="mt-1 text-[11px] text-gray-400">Pilih tanggal & waktu tayang artikel.</p>
        </div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Ganti thumbnail</label><input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white"></div>
        <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $article->is_pinned)) id="pin" class="rounded border-gray-300 text-gray-900 focus:ring-0"><label for="pin" class="text-sm text-gray-600">Pin di atas</label></div>
        <div class="sm:col-span-2"><button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Update</button></div>
    </form>
</div>
@endsection
