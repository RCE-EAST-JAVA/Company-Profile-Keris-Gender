@props(['name', 'value' => '', 'placeholder' => 'Tulis konten di sini...'])

<div
    data-tiptap-wrapper
    data-name="{{ $name }}"
    data-placeholder="{{ $placeholder }}"
    class="tiptap-wrapper overflow-hidden rounded-md border border-gray-300 bg-white focus-within:border-gray-500 focus-within:ring-0"
>
    {{-- Toolbar --}}
    <div class="tiptap-toolbar flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2">
        <button type="button" data-tiptap-btn="bold" class="tiptap-btn rounded px-2 py-1 text-sm font-bold text-gray-700 hover:bg-gray-200" title="Bold (Ctrl+B)"><span class="font-bold">B</span></button>
        <button type="button" data-tiptap-btn="italic" class="tiptap-btn rounded px-2 py-1 text-sm italic text-gray-700 hover:bg-gray-200" title="Italic (Ctrl+I)"><span class="italic">I</span></button>
        <button type="button" data-tiptap-btn="underline" class="tiptap-btn rounded px-2 py-1 text-sm underline text-gray-700 hover:bg-gray-200" title="Underline"><span class="underline">U</span></button>
        <button type="button" data-tiptap-btn="strike" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 line-through hover:bg-gray-200" title="Strikethrough">S</button>
        <span class="mx-1 h-5 w-px bg-gray-200"></span>
        <button type="button" data-tiptap-btn="h2" class="tiptap-btn rounded px-2 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-200" title="Heading 2">H2</button>
        <button type="button" data-tiptap-btn="h3" class="tiptap-btn rounded px-2 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-200" title="Heading 3">H3</button>
        <span class="mx-1 h-5 w-px bg-gray-200"></span>
        <button type="button" data-tiptap-btn="bulletList" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Bullet List">• List</button>
        <button type="button" data-tiptap-btn="orderedList" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Ordered List">1. List</button>
        <button type="button" data-tiptap-btn="blockquote" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Blockquote">❝</button>
        <button type="button" data-tiptap-btn="codeBlock" class="tiptap-btn rounded px-2 py-1 font-mono text-xs text-gray-700 hover:bg-gray-200" title="Code Block">&lt;&gt;</button>
        <span class="mx-1 h-5 w-px bg-gray-200"></span>
        <button type="button" data-tiptap-btn="alignLeft" class="tiptap-btn rounded px-1.5 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Align Left">≡</button>
        <button type="button" data-tiptap-btn="alignCenter" class="tiptap-btn rounded px-1.5 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Align Center">≡</button>
        <button type="button" data-tiptap-btn="alignRight" class="tiptap-btn rounded px-1.5 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Align Right">≡</button>
        <span class="mx-1 h-5 w-px bg-gray-200"></span>
        <button type="button" data-tiptap-btn="link" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Tambah Link">🔗</button>
        <button type="button" data-tiptap-btn="image" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Tambah Foto">🖼️</button>
        <button type="button" data-tiptap-btn="youtube" class="tiptap-btn rounded p-1.5 text-gray-700 hover:bg-gray-200" title="Embed YouTube">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" fill="#FF0000"/><path d="M9.545 15.568V8.432L15.818 12l-6.273 3.568z" fill="#FFFFFF"/></svg>
        </button>
        <button type="button" data-tiptap-btn="horizontalRule" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Horizontal Rule">—</button>
        <span class="mx-1 h-5 w-px bg-gray-200"></span>
        <button type="button" data-tiptap-btn="undo" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Undo">↩</button>
        <button type="button" data-tiptap-btn="redo" class="tiptap-btn rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-200" title="Redo">↪</button>
    </div>

    {{-- Editable area --}}
    <div data-tiptap-editor class="tiptap-editor min-h-[280px] max-w-none p-3 text-sm leading-relaxed text-gray-900 prose prose-sm focus:outline-none"></div>

    {{-- Hidden input for form submission --}}
    <textarea name="{{ $name }}" data-tiptap-input hidden>{{ $value }}</textarea>
    <input type="file" data-tiptap-file accept="image/*" class="hidden" tabindex="-1" />
</div>
