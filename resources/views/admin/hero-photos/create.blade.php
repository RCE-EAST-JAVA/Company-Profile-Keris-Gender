@extends('layouts.admin')
@section('title', 'Tambah Hero Photo')

@section('content')
<div class="max-w-xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.hero-photos.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-semibold">Foto</label>
            <input type="file" name="image" required accept="image/*" class="w-full text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Caption</label>
            <input name="caption" value="{{ old('caption') }}" class="w-full rounded-lg border-gray-300 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1 block text-sm font-semibold">Order</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            <div class="flex items-end gap-2 pb-2">
                <input type="checkbox" name="is_active" value="1" checked id="active" class="rounded">
                <label for="active" class="text-sm">Aktif</label>
            </div>
        </div>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
    </form>
</div>
@endsection
