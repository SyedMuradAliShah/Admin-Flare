import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ["resources/css/admin/app.css", "resources/js/admin/app.js"],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: true,
        outDir: "public/assets/admin",
    },
    base: "/admin/"
});
