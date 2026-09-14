@extends('layouts.admin')
@section('title', 'Partners')

@section('content')
@include('components.page-header', ['title' => 'Partners', 'action' => route('admin.partners.create'), 'actionLabel' => 'Tambah Partner'])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex gap-2 border-b p-4">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nama partner..." class="w-full rounded-lg border-gray-300 text-sm focus:border-rose-500 focus:ring-rose-500">
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Cari</button>
    </form>
    <div class="grid gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($partners as $partner)
            <div class="rounded-lg border p-4">
                <div class="flex h-24 items-center justify-center rounded bg-gray-50 p-2">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-h-full object-contain">
                </div>
                <p class="mt-3 font-semibold">{{ $partner->name }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.partners.edit', $partner) }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold hover:bg-gray-200">Edit</a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Hapus partner ini?')">
                        @csrf @method('DELETE')
                        <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-sm text-gray-500">Belum ada partner. <a href="{{ route('admin.partners.create') }}" class="font-semibold text-rose-600">Tambah sekarang</a>.</p>
        @endforelse
    </div>
    <div class="border-t p-4">{{ $partners->links() }}</div>
</div>
@endsection
