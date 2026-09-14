@extends('layouts.admin')
@section('title', 'Edit Partner')

@section('content')
<div class="max-w-xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex h-24 items-center justify-center rounded bg-gray-50 p-2">
        <img src="{{ asset('storage/' . $partner->logo) }}" class="max-h-full object-contain" alt="">
    </div>
    <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="mb-1 block text-sm font-semibold">Nama Partner</label>
            <input name="name" value="{{ old('name', $partner->name) }}" required class="w-full rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Ganti Logo (opsional)</label>
            <input type="file" name="logo" accept="image/*" class="w-full text-sm">
        </div>
        <div class="flex gap-2">
            <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Update</button>
            <a href="{{ route('admin.partners.index') }}" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold">Batal</a>
        </div>
    </form>
</div>
@endsection
