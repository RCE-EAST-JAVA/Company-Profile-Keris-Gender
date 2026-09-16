@extends('layouts.admin')
@section('title', 'Tulis Artikel')

@section('content')
<div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Judul *</label><input name="title" value="{{ old('title') }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Slug (opsional, auto)</label><input name="slug" value="{{ old('slug') }}" placeholder="dikosongkan = auto" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Kategori Publikasi *</label>
            <select name="category" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="Journal Article" @selected(old('category') === 'Journal Article')>Journal Article</option>
                <option value="Book & Module" @selected(old('category') === 'Book & Module')>Book & Module</option>
                <option value="Policy Brief" @selected(old('category') === 'Policy Brief')>Policy Brief</option>
                <option value="Annual Report" @selected(old('category') === 'Annual Report')>Annual Report</option>
                <option value="Opini & Analisis" @selected(old('category') === 'Opini & Analisis')>Opini & Analisis</option>
            </select>
        </div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Excerpt</label><textarea name="excerpt" rows="2" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">{{ old('excerpt') }}</textarea></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Body *</label><x-tiptap-editor name="body" :value="old('body')" /></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Author</label><input name="author" value="{{ old('author') }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tags (koma)</label><input name="tags" value="{{ old('tags') }}" placeholder="gender, riset" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Status *</label>
            <select name="status" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tanggal Upload / Publikasi</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            <p class="mt-1 text-[11px] text-gray-400">Bisa dipilih bebas untuk mengatur tanggal tayang artikel.</p>
        </div>
        <div class="sm:col-span-2">
            <x-image-upload name="thumbnail" label="Thumbnail / Sampul Publikasi (Opsional)" :required="false" :max-size="4" aspect="video" />
        </div>
        <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned')) id="pin" class="rounded border-gray-300 text-gray-900 focus:ring-0"><label for="pin" class="text-sm text-gray-600">Pin di atas</label></div>
        <div class="sm:col-span-2"><button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan</button></div>
    </form>
</div>
@endsection
