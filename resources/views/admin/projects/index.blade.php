@extends('layouts.admin')
@section('title', 'Projects')

@section('content')
@include('components.page-header', ['title' => 'Projects', 'action' => route('admin.projects.create'), 'actionLabel' => 'Tambah Project'])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b p-4">
        <input name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="min-w-52 flex-1 rounded-lg border-gray-300 text-sm">
        <input name="category" value="{{ request('category') }}" placeholder="Kategori" class="rounded-lg border-gray-300 text-sm">
        <input name="status" value="{{ request('status') }}" placeholder="Status" class="rounded-lg border-gray-300 text-sm">
        <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr><th class="px-4 py-3">Project</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Galeri</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($projects as $project)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $project->image) }}" class="h-12 w-16 rounded object-cover" alt="">
                                <div>
                                    <p class="font-semibold">{{ $project->title }} @if($project->is_pinned)<span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[10px] text-amber-700">PINNED</span>@endif</p>
                                    <p class="text-xs text-gray-500">{{ $project->author ?? '-' }} • {{ $project->date ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $project->category }}</td>
                        <td class="px-4 py-3"><span class="rounded bg-gray-100 px-2 py-1 text-xs">{{ $project->status }}</span></td>
                        <td class="px-4 py-3">{{ $project->project_images_count }} foto</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold">Kelola</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Hapus project ini beserta galerinya?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada project.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t p-4">{{ $projects->links() }}</div>
</div>
@endsection
