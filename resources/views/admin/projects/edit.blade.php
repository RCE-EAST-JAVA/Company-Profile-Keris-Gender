@extends('layouts.admin')
@section('title', 'Edit Project')

@section('content')
<div class="grid gap-5 xl:grid-cols-3">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 xl:col-span-2">
        <h3 class="mb-4 font-serif text-[22px] font-light text-gray-900">Data Project</h3>
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Judul *</label><input name="title" value="{{ old('title', $project->title) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
            <div class="sm:col-span-2">
                <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Slug URL (Opsional)</label>
                <input name="slug" value="{{ old('slug', $project->slug) }}" placeholder="Dikosongkan = otomatis dari judul" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0">
                <p class="mt-1 text-[11px] text-gray-400">Digunakan untuk alamat link halaman detail program.</p>
            </div>
            <div class="sm:col-span-2"><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Deskripsi *</label><x-tiptap-editor name="description" :value="old('description', $project->description)" /></div>
            <div>
                <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Kategori Program *</label>
                <select name="category" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                    @php
                        $currentCat = old('category', $project->category);
                        $categories = [
                            'Flagship Fellowship',
                            'Policy Lab',
                            'In Situ Fieldwork',
                            'Riset & Advokasi',
                            'Pelatihan & Workshop',
                            'Kolaborasi Internasional',
                            'Kajian Kebijakan Publik',
                        ];
                        if ($currentCat && !in_array($currentCat, $categories)) {
                            $categories[] = $currentCat;
                        }
                    @endphp
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($currentCat === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Status Program *</label>
                <select name="status" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                    @php
                        $currentStatus = old('status', $project->status);
                        if ($currentStatus === 'Aktif') $currentStatus = 'Active';
                        if ($currentStatus === 'Selesai') $currentStatus = 'Completed';
                        if ($currentStatus === 'Mendatang') $currentStatus = 'Upcoming';
                        if ($currentStatus === 'Dalam Perencanaan') $currentStatus = 'In Planning';

                        $statuses = [
                            'Active' => 'Active',
                            'Completed' => 'Completed',
                            'Upcoming' => 'Upcoming',
                            'In Planning' => 'In Planning',
                        ];
                    @endphp
                    @foreach ($statuses as $val => $label)
                        <option value="{{ $val }}" @selected($currentStatus === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Author / Koordinator</label><input name="author" value="{{ old('author', $project->author) }}" placeholder="cth: Tim Riset GInRe" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
            <div><label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Periode / Keterangan Waktu</label><input name="date" value="{{ old('date', $project->date) }}" placeholder="cth: 2025/2026 atau Semester Gasal" class="w-full rounded-md border-gray-300 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-500 focus:ring-0"></div>
            <div>
                <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Tanggal Upload / Tayang *</label>
                <input type="date" name="published_at" value="{{ old('published_at', optional($project->published_at)->format('Y-m-d') ?: now()->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 text-sm text-gray-900 focus:border-gray-500 focus:ring-0">
                <p class="mt-1 text-[11px] text-gray-400">Pilih tanggal upload agar tersimpan rapi di database.</p>
            </div>
            <div class="flex items-end gap-2 pb-2"><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $project->is_pinned)) id="pin" class="rounded border-gray-300 text-gray-900 focus:ring-0"><label for="pin" class="text-sm text-gray-600">Pin di atas</label></div>
            <div class="sm:col-span-2">
                <x-image-upload name="image" label="Cover Image" :value="$project->image" :required="false" :max-size="4" aspect="video" />
            </div>
            <div class="sm:col-span-2"><button class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Update</button></div>
        </form>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="font-medium text-gray-900">Galeri ({{ $project->projectImages->count() }})</h3>
        <form method="POST" action="{{ route('admin.projects.images.store', $project) }}" enctype="multipart/form-data" class="mt-3 space-y-2">
            @csrf
            <input type="file" name="images[]" multiple required accept="image/jpeg,image/png,image/webp" class="w-full text-sm text-gray-500 file:mr-3 file:rounded-full file:border-0 file:bg-gray-900 file:px-4 file:py-1.5 file:text-xs file:font-medium file:text-white">
            <p class="text-[11px] text-gray-400 font-mono">Pilih satu atau beberapa foto (JPG, PNG, WEBP). Maks. 4 MB per foto. Otomatis dikonversi ke WebP.</p>
            <button class="rounded-full bg-gray-900 px-4 py-1.5 text-xs font-medium text-white hover:bg-gray-800">Upload Foto</button>
        </form>
        <div class="mt-4 grid grid-cols-2 gap-2">
            @forelse ($project->projectImages as $img)
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-1.5">
                    @if ($img->image)
                        <img src="{{ $img->image }}" class="h-24 w-full rounded-xl object-cover" alt="">
                    @endif
                    <div class="mt-1.5 flex gap-1.5">
                        <form method="POST" action="{{ route('admin.images.cover', $img) }}">
                            @csrf @method('PATCH')
                            <button class="rounded-full border border-gray-200 bg-white px-2.5 py-1 text-[10px] font-medium text-gray-500 hover:text-gray-900">Cover</button>
                        </form>
                        <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-medium text-red-600 hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-sm text-gray-400">Belum ada foto galeri.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
