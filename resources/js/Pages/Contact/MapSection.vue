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
        class="bg-purple-gray-50"
        aria-label="School location map"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-sans font-medium uppercase tracking-widest text-purple-gray-400 mb-2" aria-hidden="true">
                        {{ map.eyebrow }}
                    </p>
                    <h2
                        class="font-display font-bold text-purple-gray-800"
                        style="font-size: clamp(1.4rem, 2.5vw, 1.8rem);"
                    >
                        {{ map.heading }}
                    </h2>
                </div>
                <a
                    :href="map.openMapsHref"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm font-medium text-purple-gray-400 hover:text-purple-gray-600 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm shrink-0"
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
                    <p class="text-xs font-semibold text-purple-gray-800 font-sans">{{ map.pinTitle }}</p>
                    <p class="text-xs text-purple-gray-500 leading-snug mt-0.5" v-html="map.pinLinesHtml"></p>
                </div>
            </div>
        </div>

        <div
            class="map-closing-strip relative overflow-hidden"
            style="background: linear-gradient(to bottom, #27262b 0%, #09080c 100%);"
        >
            <div
                class="absolute inset-y-0 left-0 w-[560px] pointer-events-none"
                style="background: radial-gradient(ellipse at 0% 55%, rgba(160,158,173,0.07) 0%, transparent 65%);"
                aria-hidden="true"
            ></div>
            <div
                class="absolute inset-y-0 right-0 w-[360px] pointer-events-none"
                style="background: radial-gradient(ellipse at 100% 100%, rgba(211,12,95,0.05) 0%, transparent 60%);"
                aria-hidden="true"
            ></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-10">

                    <div class="max-w-xl">
                        <div class="w-8 h-px bg-crimson mb-6" aria-hidden="true"></div>
                        <p class="section-eyebrow mb-4" aria-hidden="true">{{ map.closing.eyebrow }}</p>
                        <h2
                            class="font-display font-bold text-purple-gray-50 mb-5"
                            style="font-size: clamp(1.6rem, 2.8vw, 2.2rem); line-height: 1.2; letter-spacing: -0.01em;"
                        >
                            {{ map.closing.heading }}
                        </h2>
                        <p class="text-white/50 text-sm sm:text-base leading-relaxed max-w-md">
                            {{ map.closing.body }}
                        </p>
                    </div>

                    <div class="shrink-0">
                        <a
                            :href="map.closing.whatsapp.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2.5 px-6 py-3 rounded-full text-sm font-medium text-white transition-all duration-200 hover:opacity-90 hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-2 focus-visible:ring-offset-purple-gray-950 min-h-[44px]"
                            style="background-color: #25D366;"
                            :aria-label="map.closing.whatsapp.ariaLabel"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ map.closing.whatsapp.label }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>
