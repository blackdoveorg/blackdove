const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Overpass', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'olive': '#808000',
                'sea' : '#01295f',
                'sky' : '#437f97',
                'sun' : '#ffb30f',
                'plasma' : '#fd151b',
                
                
            }
        }
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
