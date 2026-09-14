@extends('layouts.admin')
@section('title', 'Tulis Artikel')

@section('content')
<div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Judul *</label><input name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Slug (opsional, auto)</label><input name="slug" value="{{ old('slug') }}" placeholder="dikosongkan = auto" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Kategori *</label><input name="category" value="{{ old('category') }}" required placeholder="cth: Opini, Riset" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Excerpt</label><textarea name="excerpt" rows="2" class="w-full rounded-lg border-gray-300 text-sm">{{ old('excerpt') }}</textarea></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Body *</label><textarea name="body" rows="10" required class="w-full rounded-lg border-gray-300 text-sm">{{ old('body') }}</textarea></div>
        <div><label class="mb-1 block text-sm font-semibold">Author</label><input name="author" value="{{ old('author') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Tags (koma)</label><input name="tags" value="{{ old('tags') }}" placeholder="gender, riset" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Status *</label>
            <select name="status" required class="w-full rounded-lg border-gray-300 text-sm">
                <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                <option value="published" @selected(old('status') === 'published')>Published</option>
            </select>
        </div>
        <div><label class="mb-1 block text-sm font-semibold">Published At</label><input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Thumbnail</label><input type="file" name="thumbnail" accept="image/*" class="w-full text-sm"></div>
        <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned')) id="pin" class="rounded"><label for="pin" class="text-sm">Pin di atas</label></div>
        <div class="sm:col-span-2"><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button></div>
    </form>
</div>
@endsection
