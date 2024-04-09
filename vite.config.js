import { defineConfig } from 'vite';
import { fileURLToPath } from 'node:url';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/main.ts'],
      refresh: true,
    }),
    vue(),
  ],
  server: {
    host: true,
    hmr: {
      host: 'localhost',
    },
  },
  resolve: {
    alias: {
      '@': '/src/resources/js'
    },
  },
});
