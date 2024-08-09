import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/createEventPage.js',
                'resources/js/eventsPage.js',
                'resources/js/htmlBuilder.js',
                'resources/js/loginPage.js',
                'resources/js/registerPage.js',
                'resources/js/ticketsPage.js',
                'resources/js/updateEventPage.js',
                'resources/js/userComponent.js',
            ],
            refresh: true,
        }),
    ],
});
