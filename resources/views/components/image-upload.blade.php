@props([
    'name' => 'image',
    'label' => 'Cover Image',
    'value' => null,
    'required' => false,
    'maxSize' => 4, // in Megabytes
    'accept' => 'image/jpeg,image/png,image/webp,image/jpg',
    'aspect' => 'video', // 'video', 'square', 'auto'
    'helper' => null,
])

@php
    $maxBytes = $maxSize * 1024 * 1024;
    $existing = $value ? (str_starts_with($value, 'http') ? $value : asset($value)) : null;
    $aspectClass = match ($aspect) {
        'square' => 'aspect-square max-w-[200px]',
        'avatar' => 'aspect-square w-32 h-32 rounded-full object-cover',
        'auto' => 'max-h-64 object-contain',
        default => 'aspect-[16/9] max-h-56',
    };
@endphp

<div
    x-data="{
        previewUrl: '{{ $existing }}',
        existingUrl: '{{ $existing }}',
        fileName: '',
        fileSizeText: '',
        errorMessage: '',
        isDragging: false,
        maxBytes: {{ $maxBytes }},
        maxSizeMb: {{ $maxSize }},

        formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        handleFiles(files) {
            if (!files || files.length === 0) return;
            const file = files[0];

            // Validate file size
            if (file.size > this.maxBytes) {
                this.errorMessage = `Ukuran file terlalu besar (${this.formatBytes(file.size)}). Maksimal ukuran file adalah ${this.maxSizeMb} MB.`;
                this.$refs.fileInput.value = '';
                this.fileName = '';
                this.fileSizeText = '';
                this.previewUrl = this.existingUrl;
                return;
            }

            // Validate file type
            const acceptedTypes = '{{ $accept }}'.split(',').map(t => t.trim().toLowerCase());
            const fileType = (file.type || '').toLowerCase();
            const fileExt = '.' + (file.name.split('.').pop() || '').toLowerCase();
            const isAccepted = acceptedTypes.some(type => {
                if (type.startsWith('.')) return type === fileExt;
                return fileType === type || (type === 'image/*' && fileType.startsWith('image/'));
            });

            if (!isAccepted) {
                this.errorMessage = 'Format file tidak didukung. Harap pilih gambar dengan format JPG, PNG, atau WEBP.';
                this.$refs.fileInput.value = '';
                this.fileName = '';
                this.fileSizeText = '';
                this.previewUrl = this.existingUrl;
                return;
            }

            this.errorMessage = '';
            this.fileName = file.name;
            this.fileSizeText = this.formatBytes(file.size);
            this.previewUrl = URL.createObjectURL(file);
        },

        clear() {
            this.$refs.fileInput.value = '';
            this.fileName = '';
            this.fileSizeText = '';
            this.previewUrl = this.existingUrl;
            this.errorMessage = '';
        }
    }"
    class="space-y-2"
>
    <!-- Label & Requirements -->
    <div class="flex items-center justify-between">
        <label class="block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">
            {{ $label }}
            @if ($required && ! $existing)
                <span class="text-red-500">*</span>
            @endif
        </label>
        <span class="font-mono text-[10px] text-gray-400">
            Maks. {{ $maxSize }} MB • WebP Auto-convert
        </span>
    </div>

    <!-- Dropzone & Preview Container -->
    <div
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files); $refs.fileInput.files = $event.dataTransfer.files"
        :class="[
            'relative rounded-xl border-2 transition-all overflow-hidden bg-gray-50/50 p-4',
            isDragging ? 'border-gray-900 bg-gray-100/70 scale-[1.005]' : 'border-dashed border-gray-300 hover:border-gray-400',
            errorMessage ? 'border-red-400 bg-red-50/30' : ''
        ]"
    >
        <input
            type="file"
            name="{{ $name }}"
            x-ref="fileInput"
            accept="{{ $accept }}"
            @if ($required && ! $existing) required @endif
            @change="handleFiles($event.target.files)"
            class="hidden"
        />

        <!-- Preview State -->
        <template x-if="previewUrl">
            <div class="space-y-3">
                <div class="relative group mx-auto flex justify-center items-center overflow-hidden rounded-lg bg-neutral-900 shadow-xs border border-gray-200">
                    <img
                        :src="previewUrl"
                        alt="Preview"
                        class="{{ $aspectClass }} w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button
                            type="button"
                            @click="$refs.fileInput.click()"
                            class="rounded-full bg-white/90 hover:bg-white text-gray-900 px-3 py-1.5 text-xs font-medium shadow-sm backdrop-blur-sm transition-all"
                        >
                            Ganti Foto
                        </button>
                        <template x-if="fileName">
                            <button
                                type="button"
                                @click="clear()"
                                class="rounded-full bg-red-600/90 hover:bg-red-600 text-white px-3 py-1.5 text-xs font-medium shadow-sm backdrop-blur-sm transition-all"
                            >
                                Batalkan
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Info bar under preview -->
                <div class="flex items-center justify-between text-xs text-gray-600 px-1">
                    <div class="flex items-center gap-2 truncate">
                        <template x-if="fileName">
                            <span class="inline-flex items-center gap-1.5 text-emerald-600 font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span x-text="fileName" class="truncate max-w-[200px] sm:max-w-xs"></span>
                                <span class="text-gray-400 font-mono text-[11px]" x-text="'(' + fileSizeText + ')'"></span>
                            </span>
                        </template>
                        <template x-if="!fileName && existingUrl">
                            <span class="inline-flex items-center gap-1.5 text-gray-500 font-mono text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                <span>Foto saat ini</span>
                            </span>
                        </template>
                    </div>
                    <button
                        type="button"
                        @click="$refs.fileInput.click()"
                        class="text-xs font-mono text-gray-700 hover:text-black underline shrink-0"
                    >
                        Pilih foto lain
                    </button>
                </div>
            </div>
        </template>

        <!-- Empty / Upload Prompt State -->
        <template x-if="!previewUrl">
            <div
                @click="$refs.fileInput.click()"
                class="py-6 flex flex-col items-center justify-center cursor-pointer text-center group"
            >
                <div class="w-12 h-12 mb-3 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-gray-200 group-hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                    <span class="text-gray-900 font-semibold underline">Klik untuk memilih foto</span> atau seret ke sini
                </p>
                <p class="mt-1 text-xs text-gray-400 font-mono">
                    Format: JPG, PNG, WEBP • Maks. {{ $maxSize }} MB
                </p>
            </div>
        </template>
    </div>

    <!-- Error Message Alert -->
    <template x-if="errorMessage">
        <div class="flex items-center gap-2 text-xs text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="errorMessage"></span>
        </div>
    </template>

    @error($name)
        <p class="text-xs text-red-600 font-mono">{{ $message }}</p>
    @enderror

    @if ($helper)
        <p class="text-[11px] text-gray-400 font-mono">{{ $helper }}</p>
    @endif
</div>
