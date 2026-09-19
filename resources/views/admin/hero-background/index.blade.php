@extends('layouts.admin')
@section('title', 'Hero Background')

@section('content')
<div class="max-w-2xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-lg font-bold text-gray-900">Hero Background Landing Page</h2>
        <p class="text-sm text-gray-500">Gambar latar belakang utama layar penuh pada halaman beranda (cukup 1 gambar aktif).</p>
    </div>

    <form method="POST" action="{{ route('admin.hero-background.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-image-upload name="image" label="Foto Background Utama" :value="$heroBackground->image" :required="false" :max-size="4" aspect="video" helper="Rekomendasi resolusi: 1920x1080 atau minimal 1600px lebar, format JPG/PNG, maks 4MB." />
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-gray-800">Judul / Keterangan (opsional)</label>
            <input name="title" value="{{ old('title', $heroBackground->title) }}" placeholder="Contoh: Academic Research Center Fieldwork" class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $heroBackground->is_active ?? true)) id="active" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
            <label for="active" class="text-sm font-medium text-gray-700">Tampilkan background di halaman depan</label>
        </div>

        <div class="pt-4 border-t border-gray-100">
            <button class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black shadow-xs">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
