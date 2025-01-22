import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js', // Menambahkan path untuk file JavaScript
        './public/**/*.html'
    ],

    theme: {
        extend: {
            fontFamily: {// Font untuk teks isi
                heading: ['Montserrat'],
                roboto: ['Mona Sans', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif'],
            },
            colors: {
                // Tabel barang masuk
                'header-1': '#4B0082',
                'even-1': '#F0F4F8',
                'odd-1': '#E1E8ED',
                'teks-1': '#333333',

                // Tabel barang keluar
                'header-2': '#5A67D8',
                'even-2': '#F7FAFC',
                'odd-2': '#EDF2F7',
                'teks-2': '#2D3748',

                // Tabel barang rusak
                'header-3': '#3b256f',
                'even-3': '#fafffe',
                'odd-3': '#F0FFF4',
                'teks-3': '#4A5568',

                // Tabel stok
                'header-4': '#B794F4',
                'even-4': '#FFF5F7',
                'odd-4': '#FEFCFB',
                'teks-4': '#4B5563',

                'body': '#e3e3e3d9',

                'accent-gold': '#FFD700',
                'accent-teal': '#008080',
                'alert-crimson': '#DC143C',
            },

            screens: {
                'mobile': { 'max': '767px' },   // Handphone
                'tablet': { 'min': '768px', 'max': '1024px' }, // Tablet
                'laptop': '1025px',
            },
        },
    },

    plugins: [forms],
};
