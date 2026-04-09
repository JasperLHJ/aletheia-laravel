<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const navLinks = [
    { label: 'About', href: '/about' },
    { label: 'Programmes', href: '/programmes' },
    { label: 'Gallery', href: '/gallery' },
    { label: 'Blog', href: '/blog' },
    { label: 'Contact', href: '/contact' },
];

function handleScroll() {
    isScrolled.value = window.scrollY > window.innerHeight * 0.85;
}

function closeMobileMenu() {
    isMobileMenuOpen.value = false;
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <div class="min-h-screen bg-neutral-50 font-sans">
        <!-- Navigation -->
        <header
            role="banner"
            :class="[
                'fixed top-0 left-0 right-0 z-[60] transition-all duration-500',
                isScrolled
                    ? 'bg-espresso shadow-lg shadow-espresso-dark/20'
                    : 'bg-transparent'
            ]"
        >
            <nav
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-2 h-16 min-w-0"
                aria-label="Main navigation"
            >
                <!-- Logo / Wordmark (truncate on narrow screens so the mobile menu control stays visible) -->
                <a
                    href="/"
                    class="min-w-0 flex-1 md:flex-initial flex flex-col leading-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 focus-visible:ring-offset-espresso rounded-sm"
                    aria-label="Aletheia Resource Center — home"
                >
                    <span class="font-display text-lg sm:text-xl font-bold text-cream-50 tracking-wide truncate">Aletheia Resource Center</span>
                </a>

                <!-- Desktop Nav Links -->
                <ul class="hidden md:flex items-center gap-1" role="list">
                    <li v-for="link in navLinks" :key="link.label">
                        <a
                            :href="link.href"
                            class="px-3 py-2 text-sm font-sans font-normal text-white/70 hover:text-white transition-colors duration-150 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 focus-visible:ring-offset-espresso"
                        >
                            {{ link.label }}
                        </a>
                    </li>
                </ul>

                <!-- Desktop CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <a
                        href="#enquiry"
                        class="btn-cta text-xs px-4 py-2 min-h-[36px]"
                        style="min-height: 36px; padding: 8px 16px; font-size: 13px;"
                    >
                        Enquire Now
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button
                    class="md:hidden shrink-0 flex items-center justify-center w-11 h-11 text-white/80 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 focus-visible:ring-offset-espresso rounded-md transition-colors"
                    :aria-expanded="isMobileMenuOpen"
                    aria-controls="mobile-menu"
                    aria-label="Toggle navigation menu"
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                >
                    <svg v-if="!isMobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </nav>

            <!-- Mobile Menu Drawer -->
            <div
                v-show="isMobileMenuOpen"
                id="mobile-menu"
                class="md:hidden relative z-10 bg-espresso border-t border-white/10 px-4 py-4 shadow-lg"
            >
                <ul class="flex flex-col gap-1" role="list">
                    <li v-for="link in navLinks" :key="link.label">
                        <a
                            :href="link.href"
                            class="block px-3 py-3 text-sm font-sans text-white/80 hover:text-white hover:bg-white/10 rounded-md transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                            @click="closeMobileMenu"
                        >
                            {{ link.label }}
                        </a>
                    </li>
                    <li class="mt-3 pt-3 border-t border-white/10">
                        <a
                            href="#enquiry"
                            class="block text-center btn-cta w-full"
                            @click="closeMobileMenu"
                        >
                            Enquire Now
                        </a>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Page Content -->
        <main id="main-content" tabindex="-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-espresso-dark text-white/70" role="contentinfo">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                    <!-- School Info -->
                    <div class="md:col-span-1">
                        <div class="font-display text-xl text-white font-semibold tracking-wide mb-1">Aletheia Resource Center</div>
                        <div class="text-xs text-gold tracking-widest uppercase mb-4" style="font-size: 9px; letter-spacing: 0.16em;">Est. MCMXLVII · Excellence in Education</div>
                        <p class="text-sm text-white/60 leading-relaxed max-w-xs">
                            Nurturing curious minds and principled leaders. Every student is known by name and guided by dedicated educators.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xs font-sans font-medium text-white/40 uppercase tracking-widest mb-4">Quick Links</h3>
                        <ul class="flex flex-col gap-2" role="list">
                            <li v-for="link in navLinks" :key="link.label">
                                <a
                                    :href="link.href"
                                    class="text-sm text-white/60 hover:text-gold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm"
                                >
                                    {{ link.label }}
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#enquiry"
                                    class="text-sm text-crimson hover:text-crimson-light transition-colors duration-150 font-medium focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm"
                                >
                                    Enquire Now →
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact & Social -->
                    <div>
                        <h3 class="text-xs font-sans font-medium text-white/40 uppercase tracking-widest mb-4">Connect</h3>
                        <address class="not-italic flex flex-col gap-2 mb-6">
                            <a
                                href="tel:+60312345678"
                                class="text-sm text-white/60 hover:text-white transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm flex items-center gap-2"
                                aria-label="Call us at +603 1234 5678"
                            >
                                <svg class="w-4 h-4 shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                                +603 1234 5678
                            </a>
                            <a
                                href="mailto:info@ashfordacademy.edu.my"
                                class="text-sm text-white/60 hover:text-white transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm flex items-center gap-2"
                                aria-label="Email us at info@ashfordacademy.edu.my"
                            >
                                <svg class="w-4 h-4 shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                info@ashfordacademy.edu.my
                            </a>
                        </address>

                        <!-- Social Icons -->
                        <div class="flex items-center gap-3">
                            <a
                                href="https://facebook.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center w-9 h-9 rounded-full bg-white/10 text-white/60 hover:bg-gold hover:text-espresso transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                                aria-label="Aletheia Resource Center on Facebook"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a
                                href="https://instagram.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center w-9 h-9 rounded-full bg-white/10 text-white/60 hover:bg-gold hover:text-espresso transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                                aria-label="Aletheia Resource Center on Instagram"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a
                                href="https://wa.me/60312345678"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center w-9 h-9 rounded-full bg-white/10 text-white/60 hover:bg-[#25D366] hover:text-white transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                                aria-label="Contact Aletheia Resource Center on WhatsApp"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="mt-12 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-white/30">
                        &copy; {{ new Date().getFullYear() }} Aletheia Resource Center. All rights reserved.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-xs text-white/30 hover:text-white/60 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm">Privacy Policy</a>
                        <span class="text-white/20" aria-hidden="true">·</span>
                        <a href="#" class="text-xs text-white/30 hover:text-white/60 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm">Terms of Use</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating WhatsApp Button -->
        <a
            href="https://wa.me/60312345678"
            target="_blank"
            rel="noopener noreferrer"
            class="fixed bottom-6 right-6 z-40 flex items-center justify-center w-14 h-14 rounded-full shadow-lg shadow-black/20 transition-transform duration-200 hover:scale-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#25D366]"
            style="background-color: #25D366; position: fixed;"
            aria-label="Chat with us on WhatsApp"
        >
            <div class="relative flex items-center justify-center w-full h-full rounded-full whatsapp-pulse">
                <svg class="w-7 h-7 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
        </a>
    </div>
</template>
