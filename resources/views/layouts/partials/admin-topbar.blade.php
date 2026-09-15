<header class="sticky top-0 z-20 flex h-16 items-center justify-between gap-4 border-b border-gray-200 bg-white/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button class="rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 lg:hidden" @click="sidebarOpen = true">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    <div class="flex items-center gap-3" x-data="{ open: false }">
        <span class="hidden text-sm text-gray-500 sm:block">{{ Auth::user()->name ?? '' }}</span>
        <div class="relative">
            <button @click="open = !open" class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </button>
            <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-2 w-44 rounded-2xl border border-gray-200 bg-white py-1 shadow-lg">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block w-full px-4 py-2 text-left text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
