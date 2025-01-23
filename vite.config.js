import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    plugins: [
        vue(),
        tailwindcss(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.ts"],
            refresh: true,
        }),
    ],
});
