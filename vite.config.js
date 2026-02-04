import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import path from 'path';
export default defineConfig({
       resolve: {
        alias: {
            'ziggy': path.resolve('vendor/tightenco/ziggy/dist/index.js'),
        }
    },
    plugins: [
        laravel({
            input: "resources/js/app.js",
            ssr: "resources/js/ssr.js",
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
        // vuetify({ autoImport: true }), // Enabled by default
    ],
});
