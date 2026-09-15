@extends('layouts.admin')
@section('title', 'Profile & Akun')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div>
        <p class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Akun Pengguna</p>
        <h2 class="font-serif text-[32px] font-medium leading-tight text-gray-900">Pengaturan Profil & Keamanan</h2>
        <p class="mt-1 text-sm text-gray-500">Perbarui identitas profil administrator dan kata sandi akun Anda.</p>
    </div>

    <!-- 1. Profile Information Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui nama tampilan dan alamat email login Anda.</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5 max-w-xl">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-gray-800">
                    Nama Administrator <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
                >
                @error('name')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-800">
                    Alamat Email <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    autocomplete="username"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
                >
                @error('email')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 flex items-center gap-4">
                <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black shadow-xs">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Update Password Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900">Perbarui Kata Sandi</h3>
            <p class="text-sm text-gray-500 mt-0.5">Pastikan kata sandi baru Anda panjang dan aman untuk menjaga keamanan akun admin.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5 max-w-xl">
            @csrf
            @method('PUT')

            <div>
                <label for="update_password_current_password" class="mb-1.5 block text-sm font-semibold text-gray-800">
                    Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    id="update_password_current_password" 
                    name="current_password" 
                    autocomplete="current-password"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
                >
                @error('current_password', 'updatePassword')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password" class="mb-1.5 block text-sm font-semibold text-gray-800">
                    Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    id="update_password_password" 
                    name="password" 
                    autocomplete="new-password"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
                >
                @error('password', 'updatePassword')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="mb-1.5 block text-sm font-semibold text-gray-800">
                    Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="password" 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    autocomplete="new-password"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900 shadow-xs"
                >
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 flex items-center gap-4">
                <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black shadow-xs">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
