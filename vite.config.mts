import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'node:path';
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'

export default defineConfig({
    resolve: {
        alias: {
            '@': resolve('resources/js'),
            'Yogas': resolve('resources/js/Components/Yogas'),
            'ziggy-js': resolve('vendor/tightenco/ziggy'),
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
                {
                     '@/stores/auth': ['useAuthStore'] ,
                     '@/class/Date1': ['Date1'] ,
                     '@/class/Place': ['Place'] 
                },],
            dts: true,
            eslintrc: {
                enabled: true,
            },
        }),
    ]
})