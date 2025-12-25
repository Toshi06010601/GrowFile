import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                garamond: ['"EB Garamond"', 'serif'],
                roboto: ['"Roboto"', 'serif'],
            },
            colors: {
                // Map your Adobe Color palette names here
                'brand-primary': {
                    '50': '#ecffe5',
                    '100': '#d3ffc6',
                    '200': '#a9ff94',
                    '300': '#70ff55',
                    '400': '#41f823',
                    '500': '#1edf03',
                    '600': '#12b200',
                    '700': '#108704',
                    '800': '#126a0a',
                    '900': '#13590e',
                    '950': '#034001',
                },
                'brand-secondary': {
                    '50': '#f5f6f6',
                    '100': '#e6e7e7',
                    '200': '#cfd0d2',
                    '300': '#aeafb2',
                    '400': '#87898c',
                    '500': '#6a6c70',
                    '600': '#5b5c5f',
                    '700': '#4d4e51',
                    '800': '#444546',
                    '900': '#3c3d3d',
                    '950': '#252527',
                },
                'brand-tertiary': {
                    '50': '#f8f8f8',
                    '100': '#f2f2f2',
                    '200': '#dcdcdc',
                    '300': '#bdbdbd',
                    '400': '#989898',
                    '500': '#7c7c7c',
                    '600': '#656565',
                    '700': '#525252',
                    '800': '#464646',
                    '900': '#3d3d3d',
                    '950': '#292929',
                },
                'brand-primary-accent': {
                    '50': '#eeffe1',
                    '100': '#d6ffbd',
                    '200': '#aeff83',
                    '300': '#78ff3c',
                    '400': '#47ff03',
                    '500': '#26ff00',
                    '600': '#17cd00',
                    '700': '#119b00',
                    '800': '#107900',
                    '900': '#0d5902',
                    '950': '#023a00',
                },
                'brand-secondary-accent': {
                    '50': '#f1feef',
                    '100': '#ddffd9',
                    '200': '#bdfcb6',
                    '300': '#87f87d',
                    '400': '#4beb3d',
                    '500': '#21d413',
                    '600': '#15b009',
                    '700': '#138a0b',
                    '800': '#156c0f',
                    '900': '#11590e',
                    '950': '#022601',
                },
                
            },
        },
    },

    plugins: [forms],
};
