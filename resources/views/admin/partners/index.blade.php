@extends('layouts.admin')
@section('title', 'Partners')

@section('content')
@include('components.page-header', ['title' => 'Partners', 'eyebrow' => 'Affiliates', 'action' => route('admin.partners.create'), 'actionLabel' => 'Tambah Partner'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex gap-2 border-b border-gray-200 p-5">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nama partner..." class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <button class="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800">Cari</button>
    </form>
    <div class="grid gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($partners as $partner)
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex h-24 items-center justify-center rounded-xl bg-gray-100 p-2">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-h-full object-contain grayscale">
                </div>
                <p class="mt-3 font-medium text-gray-900">{{ $partner->name }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.partners.edit', $partner) }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Edit</a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Hapus partner ini?')">
                        @csrf @method('DELETE')
                        <button class="rounded-full bg-red-50 px-4 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-sm text-gray-400">Belum ada partner. <a href="{{ route('admin.partners.create') }}" class="font-medium text-gray-900 underline">Tambah sekarang</a>.</p>
        @endforelse
    </div>
    <div class="border-t border-gray-200 p-4">{{ $partners->links() }}</div>
</div>
@endsection
