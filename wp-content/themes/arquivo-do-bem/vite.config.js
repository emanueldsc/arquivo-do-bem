import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
export default defineConfig({
  plugins: [react()],
  server: {
    host: true, // aceita conexões externas
    port: Number(process.env.VITE_PORT) || 5173,
    strictPort: true,
    hmr: { host: 'localhost' },
    proxy: {
      '/wp-json': { target: 'http://wordpress', changeOrigin: true },
      '/wp-admin/admin-ajax.php': { target: 'http://wordpress', changeOrigin: true }
    }
  },
  build: { outDir: 'dist', emptyOutDir: true }
})
