@extends('layouts.admin')
@section('title', 'Tambah Project')

@section('content')
<div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Judul *</label><input name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Deskripsi *</label><textarea name="description" rows="5" required class="w-full rounded-lg border-gray-300 text-sm">{{ old('description') }}</textarea></div>
        <div><label class="mb-1 block text-sm font-semibold">Kategori *</label><input name="category" value="{{ old('category') }}" required placeholder="cth: Riset Gender" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Status *</label><input name="status" value="{{ old('status', 'Aktif') }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Author</label><input name="author" value="{{ old('author') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Tanggal</label><input name="date" value="{{ old('date') }}" placeholder="2026" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Published At</label><input type="date" name="published_at" value="{{ old('published_at') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned')) id="pin" class="rounded"><label for="pin" class="text-sm">Pin di atas</label></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Cover Image *</label><input type="file" name="image" required accept="image/*" class="w-full text-sm"></div>
        <div class="sm:col-span-2"><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Simpan & Kelola Galeri</button></div>
    </form>
</div>
@endsection
