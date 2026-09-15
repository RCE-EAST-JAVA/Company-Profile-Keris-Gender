@props(['title', 'action' => null, 'actionLabel' => null, 'eyebrow' => 'Manage'])

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="mb-1 font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">{{ $eyebrow }}</p>
        <h2 class="font-serif text-[30px] font-light leading-tight text-gray-900">{{ $title }}</h2>
        @if (isset($subtitle))
            <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($action)
        <a href="{{ $action }}" class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
            <span class="text-lg leading-none">+</span> {{ $actionLabel ?? 'Tambah' }}
        </a>
    @endif
</div>
