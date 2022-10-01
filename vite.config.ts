import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            'Yogas': path.resolve(__dirname, 'resources/js/Components/Yogas'),
            'Ziggy': path.resolve("vendor/tightenco/ziggy/dist"),
        },
    },
    plugins: [
        Components({
            dirs: ['resources/js'],
            dts: true,
        }),
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({

        }),
        AutoImport({
            imports: ['vue', 'pinia',
                {
                    'axios': [['default', 'axios'],]
                },
                {
                    'route': ['ziggy-js']
                },
                { '@/stores/auth': [['default', 'authStore']] },],
            dts: true,
            eslintrc: {
                enabled: true,
            },
        }),
    ]
})