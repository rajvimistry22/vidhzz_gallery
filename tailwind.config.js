import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                gold: {
                    50:  '#fdf9ee',
                    100: '#faf0d0',
                    200: '#f5de9d',
                    300: '#efc965',
                    400: '#e8b43a',
                    500: '#d4991e',
                    600: '#b97a16',
                    700: '#975c14',
                    800: '#7b4716',
                    900: '#663b16',
                    950: '#3b1e08',
                },
                rose: {
                    50:  '#fff1f2',
                    100: '#ffe4e6',
                    200: '#fecdd3',
                    300: '#fda4af',
                    400: '#fb7185',
                    500: '#f43f5e',
                    600: '#e11d48',
                    700: '#be123c',
                    800: '#9f1239',
                    900: '#881337',
                    950: '#4c0519',
                },
                cream: {
                    50:  '#fefdf8',
                    100: '#fdf8ec',
                    200: '#faf0d0',
                    300: '#f5e4a8',
                },
                charcoal: {
                    800: '#1a1a2e',
                    900: '#0f0f1a',
                },
            },
            animation: {
                'fade-in':      'fadeIn 0.6s ease-out forwards',
                'slide-up':     'slideUp 0.5s ease-out forwards',
                'slide-right':  'slideRight 0.4s ease-out forwards',
                'zoom-in':      'zoomIn 0.4s ease-out forwards',
                'float':        'float 3s ease-in-out infinite',
                'shimmer':      'shimmer 1.5s infinite',
            },
            keyframes: {
                fadeIn:     { from: { opacity: '0' },                    to: { opacity: '1' } },
                slideUp:    { from: { opacity: '0', transform: 'translateY(30px)' }, to: { opacity: '1', transform: 'translateY(0)' } },
                slideRight: { from: { opacity: '0', transform: 'translateX(-30px)' }, to: { opacity: '1', transform: 'translateX(0)' } },
                zoomIn:     { from: { opacity: '0', transform: 'scale(0.95)' }, to: { opacity: '1', transform: 'scale(1)' } },
                float:      { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-10px)' } },
                shimmer:    { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
            },
            backgroundSize: {
                'shimmer': '200% 100%',
            },
            boxShadow: {
                'luxury':   '0 4px 40px rgba(0,0,0,0.08)',
                'card':     '0 2px 20px rgba(0,0,0,0.06)',
                'hover':    '0 8px 40px rgba(0,0,0,0.12)',
                'gold':     '0 4px 20px rgba(212,153,30,0.25)',
            },
            transitionDuration: {
                '400': '400ms',
            },
        },
    },

    plugins: [forms, typography],
};
