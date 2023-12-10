// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    devtools: {enabled: true, quiet: true},
    modules: [
        ['@nuxtjs/i18n',{
            locales: ['ru',],
            defaultLocale: 'ru',
            vueI18n: {
                fallbackLocale: 'ru',
                messages: {
                    ru: {
                        route: {

                        }
                    },
                }
            }
        }]
    ],
})
