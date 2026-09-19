@extends('layouts.admin')
@section('title', 'Tambah Partner')

@section('content')
<div class="max-w-xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Nama Partner</label>
            <input name="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <x-image-upload name="logo" label="Logo Partner" :required="true" :max-size="4" accept="image/jpeg,image/png,image/svg+xml,.svg" aspect="auto" />
        </div>
        <div class="flex gap-2">
            <button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan</button>
            <a href="{{ route('admin.partners.index') }}" class="rounded-full border border-gray-300 px-5 py-2.5 text-sm text-gray-600 hover:text-gray-900">Batal</a>
        </div>
    </form>
</div>
@endsection
