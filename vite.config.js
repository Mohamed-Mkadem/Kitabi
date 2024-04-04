import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({

    plugins: [
        laravel({
            input: [
                'resources/sass/main.scss',
                'resources/sass/utilities.scss',
                'resources/js/book.js',
                'resources/js/books.js',
                'resources/js/cart-actions.js',
                'resources/js/Cart.js',
                'resources/js/cartPage.js',
                'resources/js/checkout.js',
                'resources/js/clientPage.js',
                'resources/js/clients.js',
                'resources/js/dashboard.js',
                'resources/js/edit-profile.js',
                'resources/js/faqs.js',
                'resources/js/functions.js',
                'resources/js/main.js',
                'resources/js/map.js',
                'resources/js/productPage.js',
                'resources/js/shop.js',
                'resources/js/validate-auth.js',
                'resources/js/validate-import.js',
                'resources/js/validate-login.js',
                'resources/js/validate-signup.js',
                'resources/js/Validator.js',
                'resources/js/getCities.js',


            ],

            refresh: true
        }),
    ],
});
