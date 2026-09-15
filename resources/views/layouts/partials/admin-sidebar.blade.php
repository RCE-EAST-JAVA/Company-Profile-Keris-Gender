@php
$nav = [
    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'M4 12l8-8 8 8v8H4z'],
    ['route' => 'admin.projects.index', 'label' => 'Projects', 'pattern' => 'admin.projects.*', 'icon' => 'M4 6h16M4 12h16M4 18h10'],
    ['route' => 'admin.articles.index', 'label' => 'Articles', 'pattern' => 'admin.articles.*', 'icon' => 'M5 4h14v12H5zM8 8h8M8 12h8M8 16h5'],
    ['route' => 'admin.staff.index', 'label' => 'Staff', 'pattern' => 'admin.staff.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21v-1a7 7 0 0114 0v1'],
    ['route' => 'admin.hero-photos.index', 'label' => 'Hero Photos', 'pattern' => 'admin.hero-photos.*', 'icon' => 'M4 5h16v14H4zM4 15l5-5 4 4 3-3 4 4'],
    ['route' => 'admin.partners.index', 'label' => 'Partners', 'pattern' => 'admin.partners.*', 'icon' => 'M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7z'],
];
@endphp

{{-- Mobile overlay --}}
<div class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>

<aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-white text-gray-900 transition-transform border-r border-gray-200 lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    <div class="flex h-16 items-center border-b border-gray-200 px-5">
        <div>
            <p class="text-xl font-bold leading-tight text-gray-900">GInRe</p>
            <p class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Admin Panel</p>
        </div>
    </div>
    <nav class="space-y-1 p-3">
        @foreach ($nav as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
                class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition border {{ $active ? 'bg-gray-900 border-gray-900 text-white' : 'border-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
                @if ($active)
                    <span class="ml-auto h-1.5 w-1.5 rounded-full bg-white"></span>
                @endif
            </a>
        @endforeach
    </nav>
    <div class="absolute bottom-0 w-full border-t border-gray-200 p-4">
        <a href="/" target="_blank" class="block rounded-full px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900">← Lihat Website</a>
    </div>
</aside>
