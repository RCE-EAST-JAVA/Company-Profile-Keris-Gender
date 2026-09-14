@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }} 👋</h2>
    <p class="mt-1 text-sm text-gray-500">Kelola konten company profile kelompok riset gender dari sini.</p>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    @php
        $cards = [
            ['label' => 'Projects', 'value' => $counts['projects'], 'route' => 'admin.projects.index', 'color' => 'bg-blue-600'],
            ['label' => 'Articles', 'value' => $counts['articles'], 'route' => 'admin.articles.index', 'color' => 'bg-emerald-600'],
            ['label' => 'Draft Articles', 'value' => $counts['draftArticles'], 'route' => 'admin.articles.index', 'color' => 'bg-amber-500'],
            ['label' => 'Staff', 'value' => $counts['staff'], 'route' => 'admin.staff.index', 'color' => 'bg-violet-600'],
            ['label' => 'Hero Photos', 'value' => $counts['heroPhotos'], 'route' => 'admin.hero-photos.index', 'color' => 'bg-rose-600'],
            ['label' => 'Partners', 'value' => $counts['partners'], 'route' => 'admin.partners.index', 'color' => 'bg-gray-900'],
        ];
    @endphp
    @foreach ($cards as $card)
        <a href="{{ route($card['route']) }}" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">{{ $card['label'] }}</p>
                <span class="h-3 w-3 rounded-full {{ $card['color'] }}"></span>
            </div>
            <p class="mt-2 text-3xl font-bold">{{ $card['value'] }}</p>
        </a>
    @endforeach
</div>

<div class="mt-6 grid gap-4 xl:grid-cols-2">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b px-5 py-4">
            <h3 class="font-semibold">Project Terbaru</h3>
            <a href="{{ route('admin.projects.create') }}" class="text-sm font-semibold text-rose-600 hover:underline">+ Tambah</a>
        </div>
        <ul class="divide-y">
            @forelse ($latestProjects as $p)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="truncate font-medium">{{ $p->title }}</span>
                    <span class="ml-3 shrink-0 rounded bg-gray-100 px-2 py-0.5 text-xs">{{ $p->status }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-sm text-gray-500">Belum ada project.</li>
            @endforelse
        </ul>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b px-5 py-4">
            <h3 class="font-semibold">Artikel Terbaru</h3>
            <a href="{{ route('admin.articles.create') }}" class="text-sm font-semibold text-rose-600 hover:underline">+ Tambah</a>
        </div>
        <ul class="divide-y">
            @forelse ($latestArticles as $a)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="truncate font-medium">{{ $a->title }}</span>
                    <span class="ml-3 shrink-0 rounded px-2 py-0.5 text-xs {{ $a->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $a->status }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-sm text-gray-500">Belum ada artikel.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
