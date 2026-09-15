@extends('layouts.admin')
@section('title', 'Tambah Staff')

@section('content')
<div class="max-w-2xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Nama *</label><input name="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Role *</label><input name="role" value="{{ old('role') }}" required placeholder="cth: Peneliti Senior" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Kategori *</label>
            <select name="category" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="Researcher" @selected(old('category') === 'Researcher')>Researcher</option>
                <option value="Research Assistant" @selected(old('category') === 'Research Assistant')>Research Assistant</option>
            </select>
        </div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Expertise</label><input name="expertise" value="{{ old('expertise') }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">LinkedIn URL</label><input name="linkedin" value="{{ old('linkedin') }}" placeholder="https://..." class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Foto</label><input type="file" name="image" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white"></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Deskripsi</label><textarea name="description" rows="4" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">{{ old('description') }}</textarea></div>
        <div class="sm:col-span-2"><button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan</button></div>
    </form>
</div>
@endsection
