import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'packages/componentstudio/studio/resources/css/app.css',
                'packages/componentstudio/studio/resources/js/app.js',
            ],
            refresh: true,
        }),
    ]
});
