import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path'

export default defineConfig(({ mode }) => ({
  plugins: [react()],
  root: path.resolve(__dirname, 'src'),
  base: mode === 'production'
    ? '/wp-content/themes/arquivo-do-bem/dist/'
    : '/',
  publicDir: path.resolve(__dirname, 'assets'),
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      // 🔴 AJUSTE para o SEU entry real
      input: '/react/main.jsx'
      // se seu entry for src/main.jsx => input: '/main.jsx'
    }
  },
  server: {
    port: 5173,
    strictPort: true,
    hmr: { host: 'localhost' }
  },
  resolve: {
    // ✅ alias @ aponta para src/
    alias: {
      '@': path.resolve(__dirname, 'src')
    }
  }
}))
