import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/views/componentes/css.blade.php', 'resources/views/componentes/js.blade.php'],
            refresh: true,
        }),
    ],
});
