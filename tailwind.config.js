import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Newsreader', '"Cormorant Garamond"', 'Georgia', 'serif'],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                paper: '#fafaf9',
                'paper-card': '#ffffff',
                ink: {
                    DEFAULT: '#0f0f10',
                    muted: '#686661',
                    subtle: '#8a8882',
                },
                hairline: {
                    DEFAULT: '#e5e4de',
                    strong: '#d6d4cb',
                },
                terracotta: {
                    DEFAULT: '#b83220',
                    dark: '#992819',
                    light: '#fef2f0',
                },
            },
        },
    },

    plugins: [forms],
};
