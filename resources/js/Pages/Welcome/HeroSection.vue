<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';

defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const heroRef = ref(null);
const prefersReducedMotion = ref(false);

const particles = Array.from({ length: 28 }, (_, i) => ({
    id: i,
    x: Math.random() * 100,
    y: Math.random() * 100,
    size: Math.random() * 3 + 1,
    delay: Math.random() * 6,
    duration: Math.random() * 8 + 6,
}));

let animations = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion.value) {
        gsap.set([
            '.hero-eyebrow', '.hero-title', '.hero-title-em',
            '.hero-subtitle', '.hero-ctas', '.hero-badges',
            '.hero-image-wrap', '.hero-stat',
        ], { opacity: 1, y: 0, x: 0, scale: 1 });
        return;
    }

    // Staggered entrance timeline
    const tl = gsap.timeline({ delay: 0.15 });

    tl.fromTo('.hero-eyebrow',
        { y: 24, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.65, ease: 'power3.out' }
    )
    .fromTo('.hero-title-line-1',
        { y: 40, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.75, ease: 'power3.out' },
        '-=0.35'
    )
    .fromTo('.hero-title-line-2',
        { y: 40, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.75, ease: 'power3.out' },
        '-=0.55'
    )
    .fromTo('.hero-subtitle',
        { y: 24, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.6, ease: 'power2.out' },
        '-=0.4'
    )
    .fromTo('.hero-ctas',
        { y: 20, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.55, ease: 'power2.out' },
        '-=0.3'
    )
    .fromTo('.hero-badges',
        { y: 16, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.5, ease: 'power2.out' },
        '-=0.25'
    )
    .fromTo('.hero-image-wrap',
        { opacity: 0, scale: 0.96, x: 30 },
        { opacity: 1, scale: 1, x: 0, duration: 1.0, ease: 'power3.out' },
        0.2
    )
    .fromTo('.hero-stat',
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 0.55, stagger: 0.12, ease: 'power2.out' },
        '-=0.5'
    );

    animations.push(tl);

    // Floating ambient orb
    const orb = gsap.to('.hero-orb', {
        x: 40, y: -30,
        duration: 7,
        ease: 'sine.inOut',
        yoyo: true,
        repeat: -1,
    });
    animations.push(orb);

    // Parallax on mouse move
    const section = heroRef.value;
    const onMouseMove = (e) => {
        const { clientX, clientY, currentTarget } = e;
        const { width, height } = currentTarget.getBoundingClientRect();
        const xRatio = (clientX / width - 0.5);
        const yRatio = (clientY / height - 0.5);

        gsap.to('.hero-image-inner', {
            x: xRatio * -18,
            y: yRatio * -12,
            duration: 1.2,
            ease: 'power1.out',
        });
        gsap.to('.hero-orb', {
            x: xRatio * 40,
            y: yRatio * 30,
            duration: 1.8,
            ease: 'power1.out',
        });
        gsap.to('.hero-particles-layer', {
            x: xRatio * 10,
            y: yRatio * 8,
            duration: 2,
            ease: 'power1.out',
        });
    };

    section.addEventListener('mousemove', onMouseMove);
    animations._cleanup = () => section.removeEventListener('mousemove', onMouseMove);

    // Scroll indicator bob
    const bob = gsap.to('.hero-scroll-indicator', {
        y: 8,
        duration: 1.4,
        ease: 'sine.inOut',
        yoyo: true,
        repeat: -1,
    });
    animations.push(bob);
});

onUnmounted(() => {
    animations.forEach(a => { if (a && typeof a.kill === 'function') a.kill(); });
    if (animations._cleanup) animations._cleanup();
});
</script>

<template>
    <section
        ref="heroRef"
        class="hero-section relative min-h-screen flex items-center bg-espresso-dark overflow-hidden"
        aria-labelledby="hero-heading"
    >
        <!-- Full-bleed background image -->
        <div class="absolute inset-0 z-0" aria-hidden="true">
            <img
                :src="content.backgroundImage"
                alt=""
                class="w-full h-full object-cover object-center opacity-20"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            />
            <!-- Deep vignette -->
            <div class="absolute inset-0"
                style="background: radial-gradient(ellipse 120% 100% at 60% 50%, transparent 20%, #1E0D08 85%);"
            ></div>
            <!-- Left fade for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-espresso-dark via-espresso-dark/90 to-transparent"></div>
        </div>

        <!-- Ambient glowing orb -->
        <div
            class="hero-orb absolute z-0 pointer-events-none"
            style="
                right: 8%;
                top: 15%;
                width: 560px;
                height: 560px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(167,75,26,0.28) 0%, rgba(206,120,21,0.12) 45%, transparent 70%);
                filter: blur(40px);
            "
            aria-hidden="true"
        ></div>

        <!-- Subtle secondary orb -->
        <div
            class="absolute z-0 pointer-events-none"
            style="
                left: -10%;
                bottom: -5%;
                width: 420px;
                height: 420px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(211,12,95,0.12) 0%, transparent 65%);
                filter: blur(60px);
            "
            aria-hidden="true"
        ></div>

        <!-- Floating particles layer -->
        <div class="hero-particles-layer absolute inset-0 z-0 pointer-events-none" aria-hidden="true">
            <div
                v-for="p in particles"
                :key="p.id"
                class="hero-particle absolute rounded-full"
                :style="{
                    left: p.x + '%',
                    top: p.y + '%',
                    width: p.size + 'px',
                    height: p.size + 'px',
                    animationDelay: p.delay + 's',
                    animationDuration: p.duration + 's',
                }"
            ></div>
        </div>

        <!-- Decorative grid lines -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.04]" aria-hidden="true"
            style="background-image: linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 80px 80px;"
        ></div>

        <!-- ── Main layout ── -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-24">
            <div class="grid lg:grid-cols-[1fr_auto] gap-12 xl:gap-20 items-center">

                <!-- Left: text content -->
                <div class="max-w-2xl">

                    <!-- Eyebrow -->
                    <div class="hero-eyebrow flex items-center gap-3 mb-6">
                        <span class="block w-8 h-px bg-gold opacity-70"></span>
                        <p class="text-xs font-sans font-semibold uppercase tracking-[0.22em] text-gold/80" aria-hidden="true">
                            {{ content.eyebrow }}
                        </p>
                    </div>

                    <!-- Heading — split into two lines for staggered reveal -->
                    <h1 id="hero-heading" class="hero-title font-display font-bold text-neutral-50 leading-[1.08] mb-7" style="font-size: clamp(2.6rem, 5.5vw, 4rem);">
                        <span class="hero-title-line-1 block overflow-hidden">
                            <span class="block">{{ content.titleLine1 }}</span>
                        </span>
                        <span class="hero-title-line-2 block overflow-hidden">
                            <em class="block text-gold not-italic">{{ content.titleLine2Em }}</em>
                        </span>
                    </h1>

                    <p
                        class="hero-subtitle text-white/65 leading-relaxed max-w-[480px] mb-10"
                        style="font-size: clamp(1rem, 1.8vw, 1.1rem);"
                        v-html="content.subtitleHtml"
                    ></p>

                    <!-- CTAs -->
                    <div class="hero-ctas flex flex-wrap gap-3 items-center mb-8">
                        <!-- WhatsApp — primary conversion -->
                        <a
                            :href="content.whatsapp.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="hero-btn-whatsapp group"
                            :aria-label="content.whatsapp.ariaLabel"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ content.whatsapp.label }}
                        </a>

                        <!-- Email -->
                        <a
                            :href="content.email.href"
                            class="hero-btn-ghost group"
                            :aria-label="content.email.ariaLabel"
                        >
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ content.email.label }}
                        </a>
                    </div>

                    <!-- Secondary social links row -->
                    <div class="hero-badges flex items-center gap-4">
                        <span class="text-[11px] font-sans font-medium uppercase tracking-widest text-white/30">{{ content.followUs }}</span>
                        <a
                            v-for="(s, si) in content.socialLinks"
                            :key="si"
                            :href="s.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="hero-social-link"
                            :aria-label="s.ariaLabel"
                        >
                            <svg v-if="si === 0" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <svg v-else-if="si === 1" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <svg v-else class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right: image card with inline stats -->
                <div class="hero-image-wrap hidden lg:flex flex-col gap-5 items-end">

                    <!-- Floating image frame -->
                    <div class="relative">
                        <!-- Decorative corner lines -->
                        <div class="absolute -top-3 -left-3 w-12 h-12 border-t-2 border-l-2 border-gold/40 rounded-tl-sm pointer-events-none z-20"></div>
                        <div class="absolute -bottom-3 -right-3 w-12 h-12 border-b-2 border-r-2 border-gold/40 rounded-br-sm pointer-events-none z-20"></div>

                        <!-- Inner image with parallax target -->
                        <div class="hero-image-inner w-[340px] xl:w-[400px] rounded-2xl overflow-hidden"
                            style="box-shadow: 0 32px 80px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.06);"
                        >
                            <img
                                :src="content.portrait.src"
                                :alt="content.portrait.alt"
                                class="w-full aspect-[3/4] object-cover object-top scale-[1.04]"
                                loading="eager"
                                decoding="async"
                                style="transform-origin: center top;"
                            />
                            <!-- Colour grade overlay -->
                            <div class="absolute inset-0 mix-blend-multiply opacity-30"
                                style="background: linear-gradient(135deg, #382016 0%, #A74B1A 100%);"
                            ></div>
                        </div>

                        <!-- Floating stat chips anchored to image -->
                        <div
                            v-for="(chip, ci) in content.statChips"
                            :key="ci"
                            class="hero-stat hero-stat-chip absolute"
                            :class="ci === 0 ? '-left-16 top-8' : '-left-14 bottom-16'"
                        >
                            <span class="hero-stat-value">{{ chip.value }}</span>
                            <span class="hero-stat-label" v-html="chip.labelHtml"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div
            class="hero-scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/35 z-10"
            aria-hidden="true"
        >
            <span class="text-[10px] font-sans font-medium tracking-[0.2em] uppercase">{{ content.scrollLabel }}</span>
            <div class="relative w-px h-10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent hero-scroll-line"></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* ─── Particles ─── */
.hero-particle {
    background: rgba(255, 255, 255, 0.18);
    animation: particle-float linear infinite;
}
.hero-particle:nth-child(odd) {
    background: rgba(206, 120, 21, 0.35);
}
.hero-particle:nth-child(3n) {
    background: rgba(149, 185, 31, 0.25);
}

@keyframes particle-float {
    0% { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
    10% { opacity: 1; }
    50% { transform: translateY(-60px) translateX(20px) scale(1.1); opacity: 0.7; }
    90% { opacity: 0.4; }
    100% { transform: translateY(-120px) translateX(-15px) scale(0.8); opacity: 0; }
}

/* ─── Scroll line shimmer ─── */
.hero-scroll-line {
    animation: scroll-shimmer 2.2s ease-in-out infinite;
}
@keyframes scroll-shimmer {
    0% { transform: translateY(-100%); }
    100% { transform: translateY(200%); }
}

/* ─── Buttons ─── */
.hero-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    min-height: 44px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: #FAF9F7;
    background: linear-gradient(135deg, #D30C5F 0%, #A74B1A 100%);
    border-radius: 0.5rem;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 4px 20px rgba(211,12,95,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
    transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.hero-btn-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.2s;
}
.hero-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(211,12,95,0.45), inset 0 1px 0 rgba(255,255,255,0.12);
    filter: brightness(1.08);
}
.hero-btn-primary:hover::before { opacity: 1; }
.hero-btn-primary:active { transform: translateY(0); }

.hero-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    min-height: 44px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 500;
    color: rgba(255,255,255,0.85);
    background: rgba(255,255,255,0.05);
    border-radius: 0.5rem;
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(8px);
    transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    text-decoration: none;
}
.hero-btn-ghost:hover {
    transform: translateY(-2px);
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.32);
}
.hero-btn-ghost:active { transform: translateY(0); }

/* ─── WhatsApp CTA ─── */
.hero-btn-whatsapp {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    min-height: 44px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    border-radius: 0.5rem;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 4px 20px rgba(37,211,102,0.35), inset 0 1px 0 rgba(255,255,255,0.15);
    transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.hero-btn-whatsapp::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.2s;
}
.hero-btn-whatsapp:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(37,211,102,0.45), inset 0 1px 0 rgba(255,255,255,0.15);
    filter: brightness(1.06);
}
.hero-btn-whatsapp:hover::before { opacity: 1; }
.hero-btn-whatsapp:active { transform: translateY(0); }

/* ─── Social icon links (follow row) ─── */
.hero-social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    color: rgba(255,255,255,0.4);
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.04);
    transition: color 0.2s, background 0.2s, border-color 0.2s, transform 0.2s;
    text-decoration: none;
}
.hero-social-link:hover {
    color: rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.28);
    transform: translateY(-2px);
}

/* ─── Stat chips ─── */
.hero-stat-chip {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    padding: 0.75rem 1rem;
    background: rgba(30, 13, 8, 0.75);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(206, 120, 21, 0.25);
    border-radius: 0.75rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    min-width: 110px;
}
.hero-stat-value {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #CE7815;
    line-height: 1;
}
.hero-stat-label {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.65rem;
    font-weight: 500;
    color: rgba(255,255,255,0.5);
    line-height: 1.4;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
</style>
