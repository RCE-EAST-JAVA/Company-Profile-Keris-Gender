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
                sans: ['Inter', '"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                serif: ['"Cormorant Garamond"', 'Newsreader', 'Georgia', 'serif'],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                paper: '#fafaf9',
                'paper-card': '#ffffff',
                /* Giga — admin dark tokens (DESIGN (1).md) */
                obsidian: '#000000',
                onyx: '#0f0d0d',
                charcoal: '#171615',
                graphite: '#262828',
                void: '#050404',
                'giga-paper': '#ffffff',
                ash: '#878686',
                smoke: '#6f6e6e',
                fog: '#939292',
                ember: '#fe2c02',
                'ember-red': '#fe2c02',
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
            boxShadow: {
                'giga-xl': 'rgba(0, 0, 0, 0.7) 0px 12px 32px -16px',
            },
        },
    },

    plugins: [forms],
};
