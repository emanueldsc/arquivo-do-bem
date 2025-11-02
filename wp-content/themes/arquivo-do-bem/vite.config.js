// vite.config.js
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path'

export default defineConfig(({ mode }) => ({
  plugins: [react()],
  root: path.resolve(__dirname, 'src'),
  base: mode === 'production'
    ? '/wp-content/themes/arquivo-do-bem/dist/'
    : 'http://localhost:5173/',        // 👈 base absoluta em DEV
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: '/main.jsx'
    }
  },
  server: {
    port: 5173,
    strictPort: true,
    hmr: { host: 'localhost' },
    origin: 'http://localhost:5173',
    cors: true
  },
  resolve: {
    alias: { '@': path.resolve(__dirname, 'src') }
  }
}))
