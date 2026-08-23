import { onMounted, onUnmounted, ref } from "vue";

const SYSTEM_THEME_QUERY = "(prefers-color-scheme: dark)";

const getStoredTheme = () => {
    const stored = localStorage.getItem("theme");

    return stored === "dark" || stored === "light" ? stored : null;
};

const getInitialTheme = () => {
    if (document.documentElement.classList.contains("dark")) {
        return "dark";
    }

    return (
        getStoredTheme() ??
        (window.matchMedia(SYSTEM_THEME_QUERY).matches ? "dark" : "light")
    );
};

export function useTheme() {
    const theme = ref(getInitialTheme());
    let mediaQuery;

    const applyTheme = (value, persist = true) => {
        theme.value = value;
        document.documentElement.classList.toggle("dark", value === "dark");

        if (persist) {
            localStorage.setItem("theme", value);
        }
    };

    const handleSystemThemeChange = (event) => {
        if (!getStoredTheme()) {
            applyTheme(event.matches ? "dark" : "light", false);
        }
    };

    const toggleTheme = () => {
        applyTheme(theme.value === "dark" ? "light" : "dark");
    };

    onMounted(() => {
        mediaQuery = window.matchMedia(SYSTEM_THEME_QUERY);

        const stored = getStoredTheme();

        applyTheme(
            stored ?? (mediaQuery.matches ? "dark" : "light"),
            false,
        );
        mediaQuery.addEventListener("change", handleSystemThemeChange);
    });

    onUnmounted(() => {
        mediaQuery?.removeEventListener("change", handleSystemThemeChange);
    });

    return { theme, toggleTheme };
}
