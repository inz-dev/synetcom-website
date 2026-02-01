import { createInertiaApp } from "@inertiajs/vue3";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap/dist/css/bootstrap.min.css";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import "../css/app.css";
import "./bootstrap";
// Vuetify
import { library } from "@fortawesome/fontawesome-svg-core";
import { faClock, faUser } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import BootstrapIcon from "./Components/MyComponents/BootstrapIcon.vue";
import PrimaryButton from "./Components/MyComponents/PrimaryButton.vue";
import SecondaryButton from "./Components/MyComponents/SecondaryButton.vue";
import vuetify from "./vuetify";

// import "./assets/main.css";

import AOS from "aos";
import "aos/dist/aos.css";

import AosVue from "aos-vue";
import FooterComponent from "./Components/MyComponents/Footer.component.vue";

library.add(faUser, faClock);
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({
            mounted() {
                AOS.init();
            },
            render: () => h(App, props),
        })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue)
            .use(AosVue)
            .component("PrimaryButton", PrimaryButton)
            .component("SecondaryButton", SecondaryButton)
            .component("FooterComponent", FooterComponent)
            .component("font-awesome-icon", FontAwesomeIcon)
            .component("BootstrapIcon", BootstrapIcon)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
