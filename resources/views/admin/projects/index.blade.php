@extends('layouts.admin')
@section('title', 'Projects')

@section('content')
@include('components.page-header', ['title' => 'Projects', 'eyebrow' => 'Research Portfolio', 'action' => route('admin.projects.create'), 'actionLabel' => 'Tambah Project'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
    <form method="GET" class="flex flex-wrap gap-2 border-b border-gray-200 p-5">
        <input name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="min-w-52 flex-1 rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <input name="category" value="{{ request('category') }}" placeholder="Kategori" class="rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <input name="status" value="{{ request('status') }}" placeholder="Status" class="rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
        <button class="rounded-full bg-gray-900 px-5 py-2 text-sm font-medium text-white hover:bg-gray-800">Filter</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full min-w-3xl text-left text-sm">
            <thead class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">
                <tr><th class="px-4 py-3 font-medium">Project</th><th class="px-4 py-3 font-medium">Kategori</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3 font-medium">Galeri</th><th class="px-4 py-3 text-right font-medium">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($projects as $project)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $project->image) }}" class="h-12 w-16 rounded-xl object-cover" alt="">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $project->title }} @if($project->is_pinned)<span class="ml-1 rounded-full bg-gray-900 px-2 py-0.5 font-mono text-[10px] uppercase tracking-wider text-white">Pinned</span>@endif</p>
                                    <p class="text-xs text-gray-400">{{ $project->author ?? '-' }} • {{ $project->date ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $project->category }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 font-mono text-[11px] uppercase tracking-wider text-gray-600">{{ $project->status }}</span></td>
                        <td class="px-4 py-3 text-gray-600">{{ $project->project_images_count }} foto</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Kelola</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Hapus project ini beserta galerinya?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-full bg-red-50 px-4 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada project.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-gray-200 p-4">{{ $projects->links() }}</div>
</div>
@endsection
