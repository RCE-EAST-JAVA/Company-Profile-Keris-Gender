@extends('layouts.admin')
@section('title', 'Edit Hero Photo')

@section('content')
<div class="max-w-xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <img src="{{ asset('storage/' . $heroPhoto->image) }}" class="mb-4 h-48 w-full rounded-xl object-cover" alt="">
    <form method="POST" action="{{ route('admin.hero-photos.update', $heroPhoto) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Ganti foto (opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white">
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Caption</label>
            <input name="caption" value="{{ old('caption', $heroPhoto->caption) }}" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Order</label>
                <input type="number" name="order" value="{{ old('order', $heroPhoto->order) }}" min="0" class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            </div>
            <div class="flex items-end gap-2 pb-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $heroPhoto->is_active)) id="active" class="rounded border-gray-300 text-gray-900 focus:ring-0">
                <label for="active" class="text-sm text-gray-600">Aktif</label>
            </div>
        </div>
        <button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Update</button>
    </form>
</div>
@endsection
