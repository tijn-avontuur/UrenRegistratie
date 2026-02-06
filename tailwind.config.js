/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/livewire/flux/stubs/**/*.blade.php",
        "./vendor/livewire/flux-pro/stubs/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Instrument Sans",
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                ],
            },
            colors: {
                zinc: {
                    50: "#fafafa",
                    100: "#f5f5f5",
                    200: "#e5e5e5",
                    300: "#d4d4d4",
                    400: "#a3a3a3",
                    500: "#737373",
                    600: "#525252",
                    700: "#404040",
                    800: "#262626",
                    900: "#171717",
                    950: "#0a0a0a",
                },
                primary: {
                    DEFAULT: "#422AD5",
                    focus: "#3820b0",
                },
            },
        },
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    "color-scheme": "light",
                    primary: "#422AD5",
                    "primary-content": "#ffffff",
                    secondary: "#6b7280",
                    "secondary-content": "#ffffff",
                    accent: "#422AD5",
                    "accent-content": "#ffffff",
                    neutral: "#374151",
                    "neutral-content": "#ffffff",
                    "base-100": "#ffffff",
                    "base-200": "#f3f4f6",
                    "base-300": "#e5e7eb",
                    "base-content": "#1f2937",
                    info: "#3b82f6",
                    "info-content": "#ffffff",
                    success: "#22c55e",
                    "success-content": "#ffffff",
                    warning: "#f59e0b",
                    "warning-content": "#ffffff",
                    error: "#ef4444",
                    "error-content": "#ffffff",
                },
            },
        ],
        darkTheme: false,
    },
};
