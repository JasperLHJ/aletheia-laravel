<script setup>
defineProps({
    map: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="contact-map-section"
        class="bg-neutral-50"
        aria-label="School location map"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-sans font-medium uppercase tracking-widest text-gold mb-2" aria-hidden="true">
                        {{ map.eyebrow }}
                    </p>
                    <h2
                        class="font-display font-bold text-espresso"
                        style="font-size: clamp(1.4rem, 2.5vw, 1.8rem);"
                    >
                        {{ map.heading }}
                    </h2>
                </div>
                <a
                    :href="map.openMapsHref"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gold hover:text-gold-dark transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm shrink-0"
                    :aria-label="map.openMapsAria"
                >
                    {{ map.openMapsLabel }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="relative w-full overflow-hidden shadow-inner" style="height: 420px;">
            <iframe
                :title="map.iframeTitle"
                :src="map.iframeSrc"
                width="100%"
                height="100%"
                style="border: 0; filter: grayscale(15%) contrast(1.05);"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="absolute inset-0 w-full h-full"
            ></iframe>

            <div
                class="absolute bottom-4 left-4 bg-white rounded-xl shadow-lg px-4 py-3 flex items-start gap-3 max-w-xs pointer-events-none"
                aria-hidden="true"
            >
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-8 h-8 rounded-full bg-crimson flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-2.003 3.5-4.697 3.5-8.327a8 8 0 10-16 0c0 3.63 1.555 6.324 3.5 8.327a19.583 19.583 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-800 font-sans">{{ map.pinTitle }}</p>
                    <p class="text-xs text-neutral-500 leading-snug mt-0.5" v-html="map.pinLinesHtml"></p>
                </div>
            </div>
        </div>
    </section>
</template>
