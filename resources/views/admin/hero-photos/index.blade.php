@extends('layouts.admin')
@section('title', 'Hero Photos')

@section('content')
@include('components.page-header', ['title' => 'Hero Photos', 'action' => route('admin.hero-photos.create'), 'actionLabel' => 'Tambah Foto'])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="flex gap-2 border-b p-4 text-sm">
        <a href="{{ route('admin.hero-photos.index') }}" class="rounded-lg px-3 py-1.5 {{ !request('status') ? 'bg-gray-900 text-white' : 'bg-gray-100' }}">Semua</a>
        <a href="?status=active" class="rounded-lg px-3 py-1.5 {{ request('status') === 'active' ? 'bg-gray-900 text-white' : 'bg-gray-100' }}">Aktif</a>
        <a href="?status=inactive" class="rounded-lg px-3 py-1.5 {{ request('status') === 'inactive' ? 'bg-gray-900 text-white' : 'bg-gray-100' }}">Nonaktif</a>
    </div>
    <div class="grid gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($photos as $photo)
            <div class="rounded-lg border p-3">
                <img src="{{ asset('storage/' . $photo->image) }}" class="h-40 w-full rounded object-cover" alt="">
                <p class="mt-2 truncate text-sm font-medium">{{ $photo->caption ?? '-' }}</p>
                <p class="text-xs text-gray-500">Order: {{ $photo->order }} • {{ $photo->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                <div class="mt-2 flex gap-2">
                    <a href="{{ route('admin.hero-photos.edit', $photo) }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.hero-photos.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-sm text-gray-500">Belum ada foto.</p>
        @endforelse
    </div>
    <div class="border-t p-4">{{ $photos->links() }}</div>
</div>
@endsection
