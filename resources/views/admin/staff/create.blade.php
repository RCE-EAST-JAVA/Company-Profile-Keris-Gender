@extends('layouts.admin')
@section('title', 'Tambah Staff')

@section('content')
<div class="max-w-2xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div><label class="mb-1 block text-sm font-semibold">Nama *</label><input name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Role *</label><input name="role" value="{{ old('role') }}" required placeholder="cth: Peneliti Senior" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Kategori *</label>
            <select name="category" required class="w-full rounded-lg border-gray-300 text-sm">
                <option value="Researcher" @selected(old('category') === 'Researcher')>Researcher</option>
                <option value="Research Assistant" @selected(old('category') === 'Research Assistant')>Research Assistant</option>
            </select>
        </div>
        <div><label class="mb-1 block text-sm font-semibold">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Expertise</label><input name="expertise" value="{{ old('expertise') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">LinkedIn URL</label><input name="linkedin" value="{{ old('linkedin') }}" placeholder="https://..." class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Foto</label><input type="file" name="image" required accept="image/*" class="w-full text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Deskripsi</label><textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 text-sm">{{ old('description') }}</textarea></div>
        <div class="sm:col-span-2"><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button></div>
    </form>
</div>
@endsection
