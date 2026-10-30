// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  modules: ['@nuxtjs/tailwindcss', '@vite-pwa/nuxt'],
  typescript: {
    strict: true
  },
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8000/api'
    }
  },
  app: {
    head: {
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: 'anonymous' },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700&family=Quicksand:wght@500;600;700&display=swap'
        },
        { rel: 'manifest', href: '/manifest.webmanifest' }
      ],
      meta: [{ name: 'theme-color', content: '#702506' }]
    }
  },
  pwa: {
    registerType: 'autoUpdate',
    manifest: {
      name: 'Café Precios',
      short_name: 'CaféPrecios',
      description: 'Precios del café en Colombia para caficultores',
      lang: 'es-CO',
      theme_color: '#702506',
      background_color: '#fff8f6',
      display: 'standalone',
      start_url: '/',
      icons: [
        {
          src: '/favicon.ico',
          sizes: '48x48',
          type: 'image/x-icon'
        }
      ]
    }
  }
})
