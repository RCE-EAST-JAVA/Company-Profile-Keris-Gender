@props(['message' => null, 'id' => null])
<div x-data="{ show: true }" x-show="show" class="mb-4 flex items-start justify-between gap-4 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-sm {{ $attributes->get('class') }}">
    <div>{{ $message ?? $slot }}</div>
    <button @click="show = false" class="font-bold text-gray-400 hover:text-gray-600">×</button>
</div>
