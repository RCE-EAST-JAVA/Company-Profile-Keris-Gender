@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="font-serif text-[42px] font-medium leading-tight text-gray-900">Selamat datang, {{ Auth::user()->name }}</h2>
    <p class="mt-1 text-sm text-gray-500">Kelola konten website Center for Gender and International Relations Studies (GInRe) dari sini.</p>
</div>

<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @php
        $cards = [
            ['label' => 'Projects', 'value' => $counts['projects'], 'route' => 'admin.projects.index', 'accent' => false],
            ['label' => 'Articles', 'value' => $counts['articles'], 'route' => 'admin.articles.index', 'accent' => false],
            ['label' => 'Draft Articles', 'value' => $counts['draftArticles'], 'route' => 'admin.articles.index', 'accent' => true],
            ['label' => 'Staff', 'value' => $counts['staff'], 'route' => 'admin.staff.index', 'accent' => false],
            ['label' => 'Hero Photos', 'value' => $counts['heroPhotos'], 'route' => 'admin.hero-photos.index', 'accent' => false],
            ['label' => 'Partners', 'value' => $counts['partners'], 'route' => 'admin.partners.index', 'accent' => false],
        ];
    @endphp
    @foreach ($cards as $card)
        <a href="{{ route($card['route']) }}" class="rounded-2xl border p-5 shadow-sm transition {{ $card['accent'] ? 'border-ember-red bg-ember-red text-white' : 'border-gray-200 bg-white text-gray-900 hover:border-gray-300' }}">
            <div class="flex items-center justify-between">
                <p class="font-mono text-[11px] uppercase tracking-[0.09em] {{ $card['accent'] ? 'text-white/70' : 'text-gray-500' }}">{{ $card['label'] }}</p>
                <span class="h-1.5 w-1.5 rounded-full {{ $card['accent'] ? 'bg-white' : 'bg-gray-300' }}"></span>
            </div>
            <p class="mt-2 text-[44px] font-normal leading-none tracking-[-0.03em]">{{ $card['value'] }}</p>
        </a>
    @endforeach
</div>

<div class="mt-5 grid gap-5 xl:grid-cols-2">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h3 class="font-serif text-[22px] font-light text-gray-900">Project Terbaru</h3>
            <a href="{{ route('admin.projects.create') }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">+ Tambah</a>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse ($latestProjects as $p)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="truncate font-medium text-gray-900">{{ $p->title }}</span>
                    <span class="ml-3 shrink-0 rounded-full bg-gray-100 px-2.5 py-0.5 font-mono text-[11px] uppercase tracking-wider text-gray-500">{{ $p->status }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-sm text-gray-400">Belum ada project.</li>
            @endforelse
        </ul>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h3 class="font-serif text-[22px] font-light text-gray-900">Artikel Terbaru</h3>
            <a href="{{ route('admin.articles.create') }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">+ Tambah</a>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse ($latestArticles as $a)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="truncate font-medium text-gray-900">{{ $a->title }}</span>
                    <span class="ml-3 shrink-0 rounded-full px-2.5 py-0.5 font-mono text-[11px] uppercase tracking-wider {{ $a->status === 'published' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $a->status }}</span>
                </li>
            @empty
                <li class="px-5 py-6 text-sm text-gray-400">Belum ada artikel.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
