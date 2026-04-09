<template>
    <section
        id="enquiry"
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="cta-heading"
    >
        <div id="cta-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="cta-content bg-espresso rounded-2xl overflow-hidden relative">
                <div
                    class="absolute inset-0 opacity-5"
                    style="background-image: repeating-linear-gradient(45deg, #CE7815 0, #CE7815 1px, transparent 0, transparent 50%); background-size: 20px 20px;"
                    aria-hidden="true"
                ></div>
                <div
                    class="absolute right-0 top-0 w-80 h-80 rounded-full -translate-y-1/3 translate-x-1/4 opacity-10"
                    style="background: #A74B1A;"
                    aria-hidden="true"
                ></div>

                <div class="relative z-10 px-8 sm:px-12 lg:px-16 py-14 sm:py-20 flex flex-col lg:flex-row items-center justify-between gap-10">
                    <div class="text-center lg:text-left max-w-xl">
                        <p class="section-eyebrow text-gold mb-3">Admissions Open 2026</p>
                        <h2
                            id="cta-heading"
                            class="font-display font-bold text-neutral-50 mb-4"
                            style="font-size: clamp(1.8rem, 3vw, 2.5rem); line-height: 1.2;"
                        >
                            Ready to Begin Your Child's Journey?
                        </h2>
                        <p class="text-white/65 text-base leading-relaxed">
                            Book a private tour, speak with our admissions team, or request our school prospectus. We'd love to meet your family.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-center gap-4 shrink-0">
                        <a
                            href="https://wa.me/60312345678"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-cta w-full sm:w-auto"
                            aria-label="Book a visit via WhatsApp"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Book a Visit
                        </a>
                        <a
                            href="mailto:admissions@aletheiaacademy.edu.my"
                            class="btn-ghost-light w-full sm:w-auto"
                            aria-label="Email our admissions team"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            Email Admissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
