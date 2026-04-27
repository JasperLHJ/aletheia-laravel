<script setup>
defineProps({
    visit: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="contact-visit-section"
        class="bg-purple-gray-100 py-16 sm:py-20"
        aria-labelledby="visit-info-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs font-sans font-medium uppercase tracking-widest text-purple-gray-400 mb-3" aria-hidden="true">
                    {{ visit.eyebrow }}
                </p>
                <h2
                    id="visit-info-heading"
                    class="font-display font-bold text-purple-gray-800"
                    style="font-size: clamp(1.6rem, 3vw, 2.2rem);"
                >
                    {{ visit.heading }}
                </h2>
                <p class="mt-3 text-purple-gray-600 text-sm sm:text-base max-w-lg mx-auto leading-relaxed">
                    {{ visit.intro }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">

                <div class="visit-info-card flex flex-col items-start p-7 rounded-2xl bg-white border border-purple-gray-200 shadow-sm">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-gray-800/10 mb-5">
                        <svg class="w-6 h-6 text-purple-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-purple-gray-800 text-lg mb-3">{{ visit.addressCard.title }}</h3>
                    <address class="not-italic text-purple-gray-600 text-sm leading-relaxed">
                        <p
                            v-for="(line, li) in visit.addressCard.lines"
                            :key="li"
                            :class="li === 0 ? 'font-medium text-purple-gray-700' : ''"
                        >
                            {{ line }}
                        </p>
                    </address>
                    <a
                        :href="visit.addressCard.directionsHref"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-flex items-center gap-1.5 text-sm font-medium text-purple-gray-400 hover:text-purple-gray-600 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm"
                        :aria-label="visit.addressCard.directionsAria"
                    >
                        {{ visit.addressCard.directionsLabel }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>

                <div class="visit-info-card flex flex-col items-start p-7 rounded-2xl bg-white border border-purple-gray-200 shadow-sm">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-gray-400/10 mb-5">
                        <svg class="w-6 h-6 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-purple-gray-800 text-lg mb-3">{{ visit.hoursCard.title }}</h3>
                    <dl class="w-full text-sm space-y-2">
                        <div
                            v-for="(row, ri) in visit.hoursCard.rows"
                            :key="row.day"
                            class="flex justify-between items-center py-1.5"
                            :class="ri < visit.hoursCard.rows.length - 1 ? 'border-b border-purple-gray-100' : ''"
                        >
                            <dt class="text-purple-gray-500">{{ row.day }}</dt>
                            <dd
                                class="font-medium"
                                :class="row.hoursMuted ? 'text-purple-gray-400 italic' : 'text-purple-gray-700'"
                            >
                                {{ row.hours }}
                            </dd>
                        </div>
                    </dl>
                    <p class="mt-4 text-xs text-purple-gray-400 leading-relaxed">
                        {{ visit.hoursCard.footnote }}
                    </p>
                </div>

                <div class="visit-info-card flex flex-col items-start p-7 rounded-2xl bg-white border border-purple-gray-200 shadow-sm">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-crimson/10 mb-5">
                        <svg class="w-6 h-6 text-crimson" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-purple-gray-800 text-lg mb-3">{{ visit.socialCard.title }}</h3>
                    <p class="text-purple-gray-600 text-sm leading-relaxed mb-5">
                        {{ visit.socialCard.body }}
                    </p>
                    <div class="flex flex-col gap-3 w-full">
                        <a
                            v-for="link in visit.socialCard.links"
                            :key="link.href + link.label"
                            :href="link.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-3 text-sm text-purple-gray-600 hover:text-purple-gray-800 transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm"
                            :aria-label="link.ariaLabel"
                        >
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-gray-100 group-hover:bg-purple-gray-800 group-hover:text-white transition-all duration-200">
                                <svg
                                    v-if="link.label === 'Facebook'"
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <svg
                                    v-else-if="link.label === 'Instagram'"
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <svg
                                    v-else
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </span>
                            <span>{{ link.label }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>
