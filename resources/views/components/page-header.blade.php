@props(['title', 'action' => null, 'actionLabel' => null])

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
        @if (isset($subtitle))
            <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($action)
        <a href="{{ $action }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
            <span class="text-lg leading-none">+</span> {{ $actionLabel ?? 'Tambah' }}
        </a>
    @endif
</div>
