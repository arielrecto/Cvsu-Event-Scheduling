import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    daisyui: {
        themes: [
            {
                cvsu: {
                    primary: "#FBFADA",

                    secondary: "#ADBC9F",

                    accent: "#436850",

                    neutral: "#12372A",

                    "base-100": "#f3f4f6",

                    info: "#06b6d4",

                    success: "#15803d",

                    warning: "#eab308",

                    error: "#ef4444",
                },
            },
        ],
    },

    plugins: [forms, require("daisyui")],
};
