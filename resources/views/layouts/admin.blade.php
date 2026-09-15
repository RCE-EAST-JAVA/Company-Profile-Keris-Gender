<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'GInRe') }} Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/admin/tiptap.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        :root { color-scheme: light; }
        body { background-color: #ffffff; }
        ::selection { background-color: #0f0d0d; color: #ffffff; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900">
<div class="min-h-screen lg:flex" x-data="{ sidebarOpen: false }">
    @include('layouts.partials.admin-sidebar')

    <div class="flex-1 min-w-0 lg:pl-64">
        @include('layouts.partials.admin-topbar')

        <main class="p-4 sm:p-6 lg:p-8">
            @if (session('success'))
                <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any() && !isset($hideErrorBag))
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Periksa kembali isian form:</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
