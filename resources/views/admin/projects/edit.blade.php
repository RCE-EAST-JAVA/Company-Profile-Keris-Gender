@extends('layouts.admin')
@section('title', 'Edit Project')

@section('content')
<div class="grid gap-4 xl:grid-cols-3">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm xl:col-span-2">
        <h3 class="mb-4 font-semibold">Data Project</h3>
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Judul *</label><input name="title" value="{{ old('title', $project->title) }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Deskripsi *</label><textarea name="description" rows="5" required class="w-full rounded-lg border-gray-300 text-sm">{{ old('description', $project->description) }}</textarea></div>
            <div><label class="mb-1 block text-sm font-semibold">Kategori *</label><input name="category" value="{{ old('category', $project->category) }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div><label class="mb-1 block text-sm font-semibold">Status *</label><input name="status" value="{{ old('status', $project->status) }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div><label class="mb-1 block text-sm font-semibold">Author</label><input name="author" value="{{ old('author', $project->author) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div><label class="mb-1 block text-sm font-semibold">Tanggal</label><input name="date" value="{{ old('date', $project->date) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div><label class="mb-1 block text-sm font-semibold">Published At</label><input type="date" name="published_at" value="{{ old('published_at', optional($project->published_at)->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
            <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $project->is_pinned)) id="pin" class="rounded"><label for="pin" class="text-sm">Pin di atas</label></div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-semibold">Cover saat ini</label>
                <img src="{{ asset('storage/' . $project->image) }}" class="h-40 rounded object-cover" alt="">
                <label class="mt-2 block text-sm font-semibold">Ganti cover (opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm">
            </div>
            <div class="sm:col-span-2"><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Update</button></div>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="font-semibold">Galeri ({{ $project->projectImages->count() }})</h3>
        <form method="POST" action="{{ route('admin.projects.images.store', $project) }}" enctype="multipart/form-data" class="mt-3 space-y-2">
            @csrf
            <input type="file" name="images[]" multiple required accept="image/*" class="w-full text-sm">
            <button class="rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white">Upload Foto</button>
        </form>
        <div class="mt-4 grid grid-cols-2 gap-2">
            @forelse ($project->projectImages as $img)
                <div class="rounded border p-1">
                    <img src="{{ asset('storage/' . $img->image) }}" class="h-24 w-full rounded object-cover" alt="">
                    <div class="mt-1 flex gap-1">
                        <form method="POST" action="{{ route('admin.images.cover', $img) }}">
                            @csrf @method('PATCH')
                            <button class="rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold">Cover</button>
                        </form>
                        <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button class="rounded bg-red-50 px-2 py-1 text-[10px] font-semibold text-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-sm text-gray-500">Belum ada foto galeri.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
