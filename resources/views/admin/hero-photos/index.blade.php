@extends('layouts.admin')
@section('title', 'Hero Photos')

@section('content')
@include('components.page-header', ['title' => 'Hero Photos', 'eyebrow' => 'Atmospheric Imagery', 'action' => route('admin.hero-photos.create'), 'actionLabel' => 'Tambah Foto'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="flex gap-2 border-b border-gray-200 p-5 text-sm">
        <a href="{{ route('admin.hero-photos.index') }}" class="rounded-full px-4 py-1.5 font-medium {{ !request('status') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:text-gray-900' }}">Semua</a>
        <a href="?status=active" class="rounded-full px-4 py-1.5 font-medium {{ request('status') === 'active' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:text-gray-900' }}">Aktif</a>
        <a href="?status=inactive" class="rounded-full px-4 py-1.5 font-medium {{ request('status') === 'inactive' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:text-gray-900' }}">Nonaktif</a>
    </div>
    <div class="grid gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($photos as $photo)
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <img src="{{ asset('storage/' . $photo->image) }}" class="h-40 w-full rounded-xl object-cover" alt="">
                <p class="mt-3 truncate text-sm font-medium text-gray-900">{{ $photo->caption ?? '-' }}</p>
                <p class="font-mono text-xs text-gray-400">Order: {{ $photo->order }} • {{ $photo->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.hero-photos.edit', $photo) }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Edit</a>
                    <form method="POST" action="{{ route('admin.hero-photos.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button class="rounded-full bg-red-50 px-4 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-sm text-gray-400">Belum ada foto.</p>
        @endforelse
    </div>
    <div class="border-t border-gray-200 p-4">{{ $photos->links() }}</div>
</div>
@endsection
