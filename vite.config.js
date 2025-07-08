import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/dropzoner.js',
                'resources/js/react.tsx',
            ],
            refresh: true,
        }),
        react(),
    ],
    
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    
    // no hashing output
    build: {
        // outDir: "dist",
        target: 'esnext',
        rollupOptions: {
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].css',
            }
        },
    },
    esbuild: {
        drop: ['console', 'debugger']
    }
});
