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
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
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
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        AutoImport({
            imports: ['vue', 'pinia',
                {
                    'axios': [['default', 'axios'],]
                },
                { '@/stores/auth': ['useAuthStore'] },],
            dts: true,
            eslintrc: {
                enabled: true,
            },
        }),
    ]
})