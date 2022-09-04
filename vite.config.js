import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            'Yogas': path.resolve(__dirname, 'resources/js/Components/Yogas'),
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
            /*   include: [
                  /\.[tj]sx?$/, // .ts, .tsx, .js, .jsx
                  /\.vue$/, /\.vue\?vue/, // .vue
                  /\.md$/, // .md
                ], */
            imports: ['vue', 'pinia', {
                'axios': [                // default imports
                    ['default', 'axios'], // import { default as axios } from 'axios',
                ]
            },
                { '@/stores/auth': [['default', 'authStore']] },],
            dts: true
        }),
    ],
});
