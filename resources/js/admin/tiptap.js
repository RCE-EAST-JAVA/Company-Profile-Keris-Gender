import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import Youtube from '@tiptap/extension-youtube';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import Placeholder from '@tiptap/extension-placeholder';

function initTiptap() {
    const wrappers = document.querySelectorAll('[data-tiptap-wrapper]');
    if (!wrappers.length) return;

    wrappers.forEach((wrapper) => {
        const editorEl = wrapper.querySelector('[data-tiptap-editor]');
        const hiddenInput = wrapper.querySelector('[data-tiptap-input]');
        const fileInput = wrapper.querySelector('[data-tiptap-file]');
        const placeholder = wrapper.dataset.placeholder || 'Tulis konten di sini...';
        const initialContent = hiddenInput.value || '';

        const editor = new Editor({
            element: editorEl,
            extensions: [
                StarterKit.configure({
                    heading: { levels: [2, 3] },
                }),
                Underline,
                Link.configure({
                    openOnClick: false,
                    autolink: true,
                    HTMLAttributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer',
                    },
                }),
                Image.configure({
                    inline: false,
                    allowBase64: false,
                    HTMLAttributes: {
                        class: 'tiptap-image',
                    },
                }),
                Youtube.configure({
                    width: 640,
                    height: 360,
                    inline: false,
                    allowFullscreen: true,
                    HTMLAttributes: {
                        class: 'tiptap-youtube',
                    },
                }),
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                Placeholder.configure({
                    placeholder,
                }),
            ],
            content: initialContent,
            onUpdate: ({ editor: ed }) => {
                hiddenInput.value = ed.getHTML();
            },
        });

        // Sync initial empty check: if content is empty paragraph, hidden should be empty
        hiddenInput.value = editor.getHTML();
        // If only <p></p>, clear to avoid saving empty tag
        const syncEmpty = () => {
            const html = editor.getHTML();
            if (html === '<p></p>') {
                hiddenInput.value = '';
            } else {
                hiddenInput.value = html;
            }
        };
        editor.on('update', syncEmpty);

        // Toolbar buttons
        const btns = wrapper.querySelectorAll('[data-tiptap-btn]');
        const updateToolbarState = () => {
            btns.forEach((btn) => {
                const action = btn.dataset.tiptapBtn;
                let active = false;
                if (action === 'bold') active = editor.isActive('bold');
                else if (action === 'italic') active = editor.isActive('italic');
                else if (action === 'underline') active = editor.isActive('underline');
                else if (action === 'strike') active = editor.isActive('strike');
                else if (action === 'h2') active = editor.isActive('heading', { level: 2 });
                else if (action === 'h3') active = editor.isActive('heading', { level: 3 });
                else if (action === 'bulletList') active = editor.isActive('bulletList');
                else if (action === 'orderedList') active = editor.isActive('orderedList');
                else if (action === 'blockquote') active = editor.isActive('blockquote');
                else if (action === 'codeBlock') active = editor.isActive('codeBlock');
                else if (action === 'alignLeft') active = editor.isActive({ textAlign: 'left' });
                else if (action === 'alignCenter') active = editor.isActive({ textAlign: 'center' });
                else if (action === 'alignRight') active = editor.isActive({ textAlign: 'right' });
                btn.classList.toggle('is-active', active);
            });
        };

        editor.on('selectionUpdate', updateToolbarState);
        editor.on('update', updateToolbarState);
        // initial
        setTimeout(updateToolbarState, 100);

        btns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const action = btn.dataset.tiptapBtn;
                switch (action) {
                    case 'bold':
                        editor.chain().focus().toggleBold().run();
                        break;
                    case 'italic':
                        editor.chain().focus().toggleItalic().run();
                        break;
                    case 'underline':
                        editor.chain().focus().toggleUnderline().run();
                        break;
                    case 'strike':
                        editor.chain().focus().toggleStrike().run();
                        break;
                    case 'h2':
                        editor.chain().focus().toggleHeading({ level: 2 }).run();
                        break;
                    case 'h3':
                        editor.chain().focus().toggleHeading({ level: 3 }).run();
                        break;
                    case 'bulletList':
                        editor.chain().focus().toggleBulletList().run();
                        break;
                    case 'orderedList':
                        editor.chain().focus().toggleOrderedList().run();
                        break;
                    case 'blockquote':
                        editor.chain().focus().toggleBlockquote().run();
                        break;
                    case 'codeBlock':
                        editor.chain().focus().toggleCodeBlock().run();
                        break;
                    case 'alignLeft':
                        editor.chain().focus().setTextAlign('left').run();
                        break;
                    case 'alignCenter':
                        editor.chain().focus().setTextAlign('center').run();
                        break;
                    case 'alignRight':
                        editor.chain().focus().setTextAlign('right').run();
                        break;
                    case 'horizontalRule':
                        editor.chain().focus().setHorizontalRule().run();
                        break;
                    case 'undo':
                        editor.chain().focus().undo().run();
                        break;
                    case 'redo':
                        editor.chain().focus().redo().run();
                        break;
                    case 'link': {
                        const prev = editor.getAttributes('link').href || '';
                        const url = window.prompt('Masukkan URL link:', prev);
                        if (url === null) break;
                        if (url === '') {
                            editor.chain().focus().unsetLink().run();
                        } else {
                            // add https if missing
                            let href = url.trim();
                            if (!/^https?:\/\//i.test(href) && !href.startsWith('mailto:') && !href.startsWith('#')) {
                                href = 'https://' + href;
                            }
                            editor.chain().focus().extendMarkRange('link').setLink({ href }).run();
                        }
                        break;
                    }
                    case 'image':
                        fileInput.click();
                        break;
                    case 'youtube': {
                        const ytUrl = window.prompt('Masukkan URL YouTube (contoh: https://www.youtube.com/watch?v=...):', '');
                        if (ytUrl) {
                            editor.commands.setYoutubeVideo({ src: ytUrl.trim() });
                        }
                        break;
                    }
                    default:
                        break;
                }
                requestAnimationFrame(updateToolbarState);
            });
        });

        // Image upload handler
        const uploadImage = async (file) => {
            if (!file || !file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                return;
            }
            if (file.size > 4 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 4MB.');
                return;
            }
            const formData = new FormData();
            formData.append('image', file);
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                btns.forEach((b) => (b.disabled = true));
                const res = await fetch('/admin/uploads/image', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf || '',
                        Accept: 'application/json',
                    },
                    body: formData,
                });
                const data = await res.json();
                if (!res.ok) {
                    const msg = data.message || data.errors?.image?.[0] || 'Gagal upload gambar.';
                    throw new Error(msg);
                }
                if (data.url) {
                    editor.chain().focus().setImage({ src: data.url }).run();
                }
            } catch (e) {
                alert(e.message || 'Gagal upload gambar.');
            } finally {
                btns.forEach((b) => (b.disabled = false));
                fileInput.value = '';
            }
        };

        fileInput.addEventListener('change', () => {
            const file = fileInput.files?.[0];
            if (file) uploadImage(file);
        });

        // Drag & drop / paste
        editorEl.addEventListener('dragover', (e) => {
            e.preventDefault();
        });
        editorEl.addEventListener('drop', (e) => {
            const file = e.dataTransfer?.files?.[0];
            if (file && file.type.startsWith('image/')) {
                e.preventDefault();
                uploadImage(file);
            }
        });
        editorEl.addEventListener('paste', (e) => {
            const file = [...(e.clipboardData?.files || [])].find((f) => f.type.startsWith('image/'));
            if (file) {
                e.preventDefault();
                uploadImage(file);
            }
        });

        // Ensure hidden input is updated before form submit
        const form = wrapper.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                const html = editor.getHTML();
                hiddenInput.value = html === '<p></p>' ? '' : html;
            });
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTiptap);
} else {
    initTiptap();
}
