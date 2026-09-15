@extends('layouts.admin')
@section('title', 'Staff')

@section('content')
@include('components.page-header', ['title' => 'Staff', 'eyebrow' => 'People', 'action' => route('admin.staff.create'), 'actionLabel' => 'Tambah Staff'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b border-gray-200 p-5">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nama/role/keahlian..." class="min-w-52 flex-1 rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <select name="category" class="rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            <option value="">Semua kategori</option>
            <option value="Researcher" @selected(request('category') === 'Researcher')>Researcher</option>
            <option value="Research Assistant" @selected(request('category') === 'Research Assistant')>Research Assistant</option>
        </select>
        <button class="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">
                <tr><th class="px-4 py-3 font-medium">Nama</th><th class="px-4 py-3 font-medium">Role</th><th class="px-4 py-3 font-medium">Kategori</th><th class="px-4 py-3 font-medium">Order</th><th class="px-4 py-3 text-right font-medium">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($staff as $person)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($person->image)
                                    <img src="{{ $person->image }}" class="h-10 w-10 rounded-full object-cover" alt="">
                                @endif
                                <span class="font-medium text-gray-900">{{ $person->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->role }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 font-mono text-[11px] uppercase tracking-wider text-gray-600">{{ $person->category }}</span></td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->sort_order }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.staff.edit', $person) }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Edit</a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $person) }}" onsubmit="return confirm('Hapus staff ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-full bg-red-50 px-4 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data staff.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-gray-200 p-4">{{ $staff->links() }}</div>
</div>
@endsection
