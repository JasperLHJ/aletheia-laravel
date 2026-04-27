import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",

    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
                display: ["Playfair Display", "Georgia", "serif"],
            },
            colors: {
                espresso: {
                    light: "#6B4535",
                    DEFAULT: "#382016",
                    dark: "#1E0D08",
                },
                ember: {
                    light: "#C96130",
                    DEFAULT: "#A74B1A",
                    dark: "#7A3410",
                },
                gold: {
                    light: "#E8A040",
                    DEFAULT: "#CE7815",
                    dark: "#9A5A0E",
                },
                crimson: {
                    light: "#E83E82",
                    DEFAULT: "#D30C5F",
                    dark: "#9A0845",
                },
                sage: {
                    light: "#B3D435",
                    DEFAULT: "#95B91F",
                    dark: "#6B870F",
                },
                slate: {
                    light: "#8D8B9A",
                    DEFAULT: "#63616E",
                    dark: "#3E3C48",
                },
                cream: {
                    50: "#fdfce8",
                    100: "#fcfac5",
                    200: "#f9f18f",
                    300: "#f5e24f",
                    400: "#f0cf1f",
                    500: "#e1b711",
                    600: "#c28f0c",
                    700: "#9b670d",
                    800: "#805113",
                    900: "#6d4316",
                    950: "#3f2309",
                },
                neutral: {
                    50: "#fafafa",
                    100: "#f4f4f5",
                    200: "#e4e3e8",
                    300: "#d4d3d9",
                    400: "#a09ead",
                    500: "#63616e",
                    600: "#514f5e",
                    700: "#3f3d48",
                    800: "#27262b",
                    900: "#18171c",
                },
                "purple-gray": {
                    50: "#fafafa",
                    100: "#f4f4f5",
                    200: "#e4e3e8",
                    300: "#d4d3d9",
                    400: "#a09ead",
                    500: "#63616e",
                    600: "#514f5e",
                    700: "#3f3d48",
                    800: "#27262b",
                    900: "#18171c",
                    950: "#09080c",
                },
            },
            fontSize: {
                display: [
                    "3.0625rem",
                    { lineHeight: "1.1", fontWeight: "700" },
                ],
                "2xl-school": [
                    "2.4375rem",
                    { lineHeight: "1.15", fontWeight: "600" },
                ],
                "xl-school": [
                    "1.9375rem",
                    { lineHeight: "1.2", fontWeight: "600" },
                ],
                "lg-school": [
                    "1.5625rem",
                    { lineHeight: "1.3", fontWeight: "500" },
                ],
                "md-school": [
                    "1.25rem",
                    { lineHeight: "1.4", fontWeight: "500" },
                ],
            },
        },
    },

    safelist: [
        "group-hover:bg-sage",
        "group-hover:bg-purple-gray-500",
        "group-hover:bg-purple-gray-400",
        "group-hover:bg-crimson",
        "group-hover:bg-purple-gray-800",
    ],

    plugins: [forms],
};
