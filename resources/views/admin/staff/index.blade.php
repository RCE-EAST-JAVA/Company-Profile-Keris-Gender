@extends('layouts.admin')
@section('title', 'Staff')

@section('content')
@include('components.page-header', ['title' => 'Staff', 'action' => route('admin.staff.create'), 'actionLabel' => 'Tambah Staff'])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b p-4">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nama/role/keahlian..." class="min-w-52 flex-1 rounded-lg border-gray-300 text-sm">
        <select name="category" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua kategori</option>
            <option value="Researcher" @selected(request('category') === 'Researcher')>Researcher</option>
            <option value="Research Assistant" @selected(request('category') === 'Research Assistant')>Research Assistant</option>
        </select>
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Order</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($staff as $person)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($person->image)
                                    <img src="{{ asset('storage/' . $person->image) }}" class="h-10 w-10 rounded-full object-cover" alt="">
                                @endif
                                <span class="font-semibold">{{ $person->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->role }}</td>
                        <td class="px-4 py-3"><span class="rounded bg-gray-100 px-2 py-1 text-xs">{{ $person->category }}</span></td>
                        <td class="px-4 py-3">{{ $person->sort_order }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.staff.edit', $person) }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold">Edit</a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $person) }}" onsubmit="return confirm('Hapus staff ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data staff.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t p-4">{{ $staff->links() }}</div>
</div>
@endsection
