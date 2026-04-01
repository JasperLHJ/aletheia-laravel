const STORAGE_KEY = 'cms-theme';

/**
 * Resolved theme for display: uses stored preference or system preference.
 */
export function getResolvedTheme() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored === 'dark' || stored === 'light') {
        return stored;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light';
}

export function applyTheme(theme) {
    document.documentElement.classList.toggle('dark', theme === 'dark');
}

export function initAppearance() {
    applyTheme(getResolvedTheme());
}

/** Persists choice and applies it (call after user explicitly toggles). */
export function toggleTheme() {
    const next = document.documentElement.classList.contains('dark')
        ? 'light'
        : 'dark';
    localStorage.setItem(STORAGE_KEY, next);
    applyTheme(next);
    return next;
}
