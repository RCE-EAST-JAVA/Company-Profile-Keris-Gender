@props(['message' => null, 'id' => null])
<div x-data="{ show: true }" x-show="show" class="mb-4 flex items-start justify-between gap-4 rounded-lg border px-4 py-3 text-sm {{ $attributes->get('class') }}">
    <div>{{ $message ?? $slot }}</div>
    <button @click="show = false" class="font-bold opacity-60 hover:opacity-100">×</button>
</div>
