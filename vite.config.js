import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel(
            {
                input: [
                    "resources/css/admin/app.css",
                    "resources/js/admin/app.js",
                ],
                refresh: true,
            },
            {
                input: [
                    "resources/css/bootstrap/app.css",
                    "resources/js/bootstrap/app.js",
                ],
                refresh: true,
            }
        ),
    ],
});
