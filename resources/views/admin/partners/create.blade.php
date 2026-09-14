@extends('layouts.admin')
@section('title', 'Tambah Partner')

@section('content')
<div class="max-w-xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-semibold">Nama Partner</label>
            <input name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 text-sm focus:border-rose-500 focus:ring-rose-500">
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Logo (jpg/png/webp/svg, max 2MB)</label>
            <input type="file" name="logo" required accept="image/*" class="w-full text-sm">
            @error('logo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2">
            <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.partners.index') }}" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold">Batal</a>
        </div>
    </form>
</div>
@endsection
