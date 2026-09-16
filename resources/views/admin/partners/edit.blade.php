@extends('layouts.admin')
@section('title', 'Edit Partner')

@section('content')
<div class="max-w-xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mb-4 flex h-24 items-center justify-center rounded-xl bg-gray-100 p-2">
        @if ($partner->isImageLogo())
            <img src="{{ $partner->logo }}" class="max-h-full object-contain grayscale" alt="">
        @else
            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold tracking-wider text-gray-700 bg-white border border-gray-200">
                Logo Teks: {{ $partner->logo ?: $partner->name }}
            </span>
        @endif
    </div>
    <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Nama Partner</label>
            <input name="name" value="{{ old('name', $partner->name) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        </div>
        <div>
            <x-image-upload name="logo" label="Logo Partner" :value="$partner->isImageLogo() ? $partner->logo : null" :required="false" :max-size="4" accept="image/jpeg,image/png,image/webp,image/svg+xml,.svg" aspect="auto" />
        </div>
        <div class="flex gap-2">
            <button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Update</button>
            <a href="{{ route('admin.partners.index') }}" class="rounded-full border border-gray-300 px-5 py-2.5 text-sm text-gray-600 hover:text-gray-900">Batal</a>
        </div>
    </form>
</div>
@endsection
