@extends('layouts.admin')
@section('title', 'Edit Partner')

@section('content')
<div class="max-w-xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mb-4 flex h-24 items-center justify-center rounded-xl bg-gray-100 p-2">
        <img src="{{ asset('storage/' . $partner->logo) }}" class="max-h-full object-contain grayscale" alt="">
    </div>
    <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Nama Partner</label>
            <input name="name" value="{{ old('name', $partner->name) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Ganti Logo (opsional)</label>
            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white">
        </div>
        <div class="flex gap-2">
            <button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Update</button>
            <a href="{{ route('admin.partners.index') }}" class="rounded-full border border-gray-300 px-5 py-2.5 text-sm text-gray-600 hover:text-gray-900">Batal</a>
        </div>
    </form>
</div>
@endsection
