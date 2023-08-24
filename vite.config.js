import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/index2.js",
                "public/assets/css/style1.css",
            ],
            refresh: true,
        }),
    ],
});
