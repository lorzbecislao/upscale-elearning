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
            fontFamily: { sans: ['Open Sans', 'sans-serif'], heading: ['Roboto', 'sans-serif'], inter: ['Inter', 'sans-serif'] },
            colors: {
                accent: '#f7fafc',
                'orange-lighter': '#fff2e7',
                orange: '#f2994a',
                primary: '#1c375b',
                secondary: '#13C296',
                'red-error': '#cc1414',
                'primary-darker': '#162c48',
                'gray-dark': '#637381',
                'gray-light': '#8899A8',
                'violet': '#9B51E0',
                'error': '#BF2C00',
                'green-success': '#00872D'
            },
        },
    },

    plugins: [forms],
};
