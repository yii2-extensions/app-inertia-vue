import { createApp, h } from 'vue'
import { createInertiaApp, router, usePage } from '@inertiajs/vue3'
import Layout from './Components/Layout.vue'
import '../css/app.css'

const appEl = document.getElementById('app')
const pageData = JSON.parse(appEl.querySelector('script[type="application/json"]').textContent)

// Include Yii2 CSRF token in all Inertia requests via X-CSRF-Token header.
// Use the shared prop (updated on every response) instead of the static meta tag.
router.on('before', (event) => {
    const page = usePage()
    const token = page.props?.csrf?.token
        || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    if (token) {
        event.detail.visit.headers['X-CSRF-Token'] = token
    }
})

createInertiaApp({
    id: 'app',
    page: pageData,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]

        if (!page) {
            throw new Error(`Page component "${name}" not found.`)
        }

        page.default.layout = page.default.layout ?? Layout

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
