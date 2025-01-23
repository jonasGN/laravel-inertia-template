import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, type DefineComponent, h } from "vue";

createInertiaApp({
    id: "app",
    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>("./Pages/**/*.vue", {
            eager: true,
        });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
