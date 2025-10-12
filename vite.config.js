import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
        server: {
        host: '0.0.0.0',       // listen on all interfaces for Docker
        port: 5173,            // default Vite port
        hmr: {
            host: 'localhost', // host your browser will access
            protocol: 'ws',    // use WebSocket for hot reload
        }
    }
});
