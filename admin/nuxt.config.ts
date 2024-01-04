// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    devtools: {enabled: true, quiet: true},
    runtimeConfig: {
        public: {
            baseURL: process.env.BASE_URL || 'http://api.pricecheck.my:82/',
        },
    }
})
