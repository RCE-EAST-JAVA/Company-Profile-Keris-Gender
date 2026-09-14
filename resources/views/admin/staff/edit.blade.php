@extends('layouts.admin')
@section('title', 'Edit Staff')

@section('content')
<div class="max-w-2xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    @if ($staff->image)
        <img src="{{ asset('storage/' . $staff->image) }}" class="mb-4 h-32 w-32 rounded-full object-cover" alt="">
    @endif
    <form method="POST" action="{{ route('admin.staff.update', $staff) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-semibold">Nama *</label><input name="name" value="{{ old('name', $staff->name) }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Role *</label><input name="role" value="{{ old('role', $staff->role) }}" required class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Kategori *</label>
            <select name="category" required class="w-full rounded-lg border-gray-300 text-sm">
                <option value="Researcher" @selected(old('category', $staff->category) === 'Researcher')>Researcher</option>
                <option value="Research Assistant" @selected(old('category', $staff->category) === 'Research Assistant')>Research Assistant</option>
            </select>
        </div>
        <div><label class="mb-1 block text-sm font-semibold">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $staff->sort_order) }}" min="0" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Expertise</label><input name="expertise" value="{{ old('expertise', $staff->expertise) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div><label class="mb-1 block text-sm font-semibold">Email</label><input type="email" name="email" value="{{ old('email', $staff->email) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">LinkedIn URL</label><input name="linkedin" value="{{ old('linkedin', $staff->linkedin) }}" class="w-full rounded-lg border-gray-300 text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Ganti foto (opsional)</label><input type="file" name="image" accept="image/*" class="w-full text-sm"></div>
        <div class="sm:col-span-2"><label class="mb-1 block text-sm font-semibold">Deskripsi</label><textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 text-sm">{{ old('description', $staff->description) }}</textarea></div>
        <div class="sm:col-span-2"><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Update</button></div>
    </form>
</div>
@endsection
