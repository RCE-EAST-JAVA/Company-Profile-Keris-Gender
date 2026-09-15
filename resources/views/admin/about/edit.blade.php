@extends('layouts.admin')
@section('title', 'About GinRe')

@section('content')
<div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Kelola Konten About GinRe</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah narasi deskripsi tentang lembaga GinRe yang tampil di halaman utama website.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.about.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-gray-800">Judul Bagian (Opsional)</label>
            <input 
                type="text" 
                name="title" 
                value="{{ old('title', $about->title ?? 'About GinRe') }}" 
                placeholder="About GinRe" 
                class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
            >
            <p class="mt-1 text-xs text-gray-400">Judul untuk referensi internal admin.</p>
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-gray-800">
                Deskripsi Lembaga <span class="text-rose-500">*</span>
            </label>
            <textarea 
                name="description" 
                rows="10" 
                required 
                placeholder="Tuliskan deskripsi lengkap, visi misi, dan fokus riset lembaga..."
                class="w-full rounded-lg border-gray-300 text-sm leading-relaxed focus:border-gray-900 focus:ring-gray-900 shadow-xs"
            >{{ old('description', $about->description) }}</textarea>
            <p class="mt-1.5 text-xs text-gray-500">
                Gunakan baris baru (Enter) untuk memisahkan paragraf. Seluruh paragraf akan tertata rapi secara otomatis di halaman utama.
            </p>
            @error('description')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
            <button type="submit" class="rounded-lg bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-black shadow-xs">
                Simpan Perubahan
            </button>
            <a href="/" target="_blank" class="text-xs font-medium text-gray-500 hover:text-gray-900">
                Lihat di Website ↗
            </a>
        </div>
    </form>
</div>
@endsection
