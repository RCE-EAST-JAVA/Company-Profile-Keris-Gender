@php
$nav = [
    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m6-11v10a1 1 0 01-1 1h-5'],
    ['route' => 'admin.projects.index', 'label' => 'Projects', 'pattern' => 'admin.projects.*', 'icon' => 'M4 6h16M4 12h16M4 18h10'],
    ['route' => 'admin.articles.index', 'label' => 'Articles', 'pattern' => 'admin.articles.*', 'icon' => 'M5 4h14v12H5zM8 8h8M8 12h8M8 16h5'],
    ['route' => 'admin.staff.index', 'label' => 'Staff', 'pattern' => 'admin.staff.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21v-1a7 7 0 0114 0v1'],
    ['route' => 'admin.hero-photos.index', 'label' => 'Hero Photos', 'pattern' => 'admin.hero-photos.*', 'icon' => 'M4 5h16v14H4zM4 15l5-5 4 4 3-3 4 4'],
    ['route' => 'admin.hero-background.edit', 'label' => 'Hero Background', 'pattern' => 'admin.hero-background.*', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['route' => 'admin.about.edit', 'label' => 'About GinRe', 'pattern' => 'admin.about.*', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['route' => 'admin.partners.index', 'label' => 'Partners', 'pattern' => 'admin.partners.*', 'icon' => 'M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7z'],
];
@endphp

{{-- Mobile overlay --}}
<div class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>

<aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-gray-900 text-gray-100 transition-transform lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    <div class="flex h-16 items-center gap-2 border-b border-white/10 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-600 font-bold">K</div>
        <div>
            <p class="text-sm font-semibold leading-tight">Keris Gender</p>
            <p class="text-xs text-gray-400">Admin Panel</p>
        </div>
    </div>
    <nav class="space-y-1 p-3">
        @foreach ($nav as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $active ? 'bg-rose-600 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="absolute bottom-0 w-full border-t border-white/10 p-4">
        <a href="/" target="_blank" class="block rounded-lg px-3 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white">← Lihat Website</a>
    </div>
</aside>
