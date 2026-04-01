import '../css/app.css';
import 'primeicons/primeicons.css';
import './bootstrap';
import { initAppearance } from './utils/appearance';

initAppearance();

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import { NeutralPreset } from './primevue-preset';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ToastService)
            .use(PrimeVue, {
                theme: {
                    preset: NeutralPreset,
                    options: {
                        darkModeSelector: '.dark',
                    },
                },
            })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#2563eb',
    },
});
