@extends('layouts.admin')
@section('title', 'Tambah Project')

@section('content')
<div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Judul *</label><input name="title" value="{{ old('title') }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div class="sm:col-span-2">
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Slug URL (Opsional)</label>
            <input name="slug" value="{{ old('slug') }}" placeholder="Dikosongkan = otomatis dari judul (cth: applied-gender-research)" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
            <p class="mt-1 text-[11px] text-gray-400">Digunakan untuk alamat link halaman detail program.</p>
        </div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Deskripsi *</label><x-tiptap-editor name="description" :value="old('description')" /></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Kategori Program *</label>
            <select name="category" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="Flagship Fellowship" @selected(old('category') === 'Flagship Fellowship')>Flagship Fellowship</option>
                <option value="Policy Lab" @selected(old('category') === 'Policy Lab')>Policy Lab</option>
                <option value="In Situ Fieldwork" @selected(old('category') === 'In Situ Fieldwork')>In Situ Fieldwork</option>
                <option value="Riset & Advokasi" @selected(old('category') === 'Riset & Advokasi')>Riset & Advokasi</option>
                <option value="Pelatihan & Workshop" @selected(old('category') === 'Pelatihan & Workshop')>Pelatihan & Workshop</option>
                <option value="Kolaborasi Internasional" @selected(old('category') === 'Kolaborasi Internasional')>Kolaborasi Internasional</option>
                <option value="Kajian Kebijakan Publik" @selected(old('category') === 'Kajian Kebijakan Publik')>Kajian Kebijakan Publik</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Status Program *</label>
            <select name="status" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                <option value="Completed" @selected(old('status') === 'Completed')>Completed</option>
                <option value="Upcoming" @selected(old('status') === 'Upcoming')>Upcoming</option>
                <option value="In Planning" @selected(old('status') === 'In Planning')>In Planning</option>
            </select>
        </div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Author / Koordinator</label><input name="author" value="{{ old('author') }}" placeholder="cth: Tim Riset GInRe" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Periode / Keterangan Waktu</label><input name="date" value="{{ old('date') }}" placeholder="cth: 2025/2026 atau Semester Gasal" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tanggal Upload / Tayang *</label>
            <input type="date" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
            <p class="mt-1 text-[11px] text-gray-400">Pilih tanggal upload agar tersimpan rapi di database.</p>
        </div>
        <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned')) id="pin" class="rounded border-gray-300 text-gray-900 focus:ring-0"><label for="pin" class="text-sm text-gray-600">Pin di atas</label></div>
        <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Cover Image *</label><input type="file" name="image" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white"></div>
        <div class="sm:col-span-2"><button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan & Kelola Galeri</button></div>
    </form>
</div>
@endsection
