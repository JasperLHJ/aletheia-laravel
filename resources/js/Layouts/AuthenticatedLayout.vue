<script setup>
import { ref, watch } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import SidebarNavLink from '@/Components/SidebarNavLink.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const mobileNavOpen = ref(false);
const toast = useToast();
const page = usePage();

watch(
    () => page.props.flash?.success,
    (message) => {
        if (message) {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: message,
                life: 4000,
            });
        }
    },
    { immediate: true },
);

function closeMobileNav() {
    mobileNavOpen.value = false;
}

/** Sidebar fills the viewport and sticks while content scrolls */
const sidebarNavClass =
    'flex h-screen w-72 shrink-0 flex-col border-r border-white/10 bg-[#1a1a2e] dark:bg-[#12121a] lg:w-80';

const userMenuContentClass =
    'py-1.5 rounded-lg bg-white shadow-xl ring-1 ring-slate-200/80 dark:bg-[#252538] dark:ring-white/10';
</script>

<template>
    <div>
        <Toast />
        <div class="flex min-h-screen bg-[#f4f6f9] dark:bg-[#1a1a1a]">
            <!-- Desktop sidebar -->
            <aside :class="['sticky top-0 hidden md:flex', sidebarNavClass]">
                <div class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-5">
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center gap-2 text-white transition hover:opacity-90"
                    >
                        <ApplicationLogo class="h-9 w-auto fill-current text-white" />
                    </Link>
                </div>
                <nav
                    class="flex flex-1 flex-col gap-1 overflow-y-auto px-3 py-6"
                    aria-label="Main navigation"
                >
                    <SidebarNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        icon="pi pi-th-large"
                    >
                        Dashboard
                    </SidebarNavLink>
                    <SidebarNavLink
                        :href="route('blogs.index')"
                        :active="route().current('blogs.*')"
                        icon="pi pi-file-edit"
                    >
                        Blog
                    </SidebarNavLink>
                    <SidebarNavLink
                        :href="route('testimonials.index')"
                        :active="route().current('testimonials.*')"
                        icon="pi pi-comments"
                    >
                        Testimonials
                    </SidebarNavLink>
                    <SidebarNavLink
                        :href="route('educators.index')"
                        :active="route().current('educators.*')"
                        icon="pi pi-users"
                    >
                        Educators
                    </SidebarNavLink>

                    <!-- User menu pinned to bottom of scroll area -->
                    <div class="mt-auto flex flex-col gap-2 border-t border-white/10 pt-4">
                        <div class="flex items-center justify-between px-1">
                            <span class="text-xs font-medium uppercase tracking-wider text-slate-500">
                                Theme
                            </span>
                            <ThemeToggle />
                        </div>
                        <Dropdown align="right" width="48" :content-classes="userMenuContentClass" :drop-up="true">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="flex w-full items-center justify-between gap-2 rounded-xl bg-white/5 px-3 py-3 text-start text-sm text-slate-200 ring-1 ring-white/10 transition hover:bg-white/10"
                                >
                                    <span class="truncate font-medium">{{
                                        $page.props.auth.user.name
                                    }}</span>
                                    <svg
                                        class="h-4 w-4 shrink-0 opacity-70"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </nav>
            </aside>

            <!-- Main column -->
            <div class="flex min-w-0 flex-1 flex-col">
                <!-- Mobile top bar -->
                <header
                    class="flex h-16 items-center justify-between gap-3 border-b border-white/10 bg-[#1a1a2e] px-4 dark:bg-[#12121a] md:hidden"
                >
                    <button
                        type="button"
                        class="inline-flex rounded-lg p-2 text-slate-300 hover:bg-white/10"
                        :aria-expanded="mobileNavOpen"
                        aria-controls="mobile-cms-nav"
                        @click="mobileNavOpen = true"
                    >
                        <span class="sr-only">Open menu</span>
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center text-white"
                    >
                        <ApplicationLogo class="h-8 w-auto fill-current text-white" />
                    </Link>
                    <ThemeToggle />
                </header>

                <!-- Mobile drawer -->
                <Transition
                    enter-active-class="transition-opacity duration-200 ease-out"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition-opacity duration-150 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="mobileNavOpen"
                        class="fixed inset-0 z-40 bg-slate-950/50 backdrop-blur-sm md:hidden"
                        aria-hidden="true"
                        @click="closeMobileNav"
                    />
                </Transition>
                <Transition
                    enter-active-class="transition transform duration-200 ease-out"
                    enter-from-class="-translate-x-full"
                    enter-to-class="translate-x-0"
                    leave-active-class="transition transform duration-150 ease-in"
                    leave-from-class="translate-x-0"
                    leave-to-class="-translate-x-full"
                >
                    <aside
                        v-show="mobileNavOpen"
                        id="mobile-cms-nav"
                        :class="[
                            'fixed inset-y-0 left-0 z-50 md:hidden',
                            sidebarNavClass,
                        ]"
                    >
                        <div class="flex h-16 items-center justify-between border-b border-white/10 px-4">
                            <span class="text-sm font-semibold text-white">Menu</span>
                            <button
                                type="button"
                                class="rounded-lg p-2 text-slate-300 hover:bg-white/10"
                                @click="closeMobileNav"
                            >
                                <span class="sr-only">Close menu</span>
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                        <nav
                            class="flex flex-1 flex-col gap-1 overflow-y-auto px-3 py-6"
                            aria-label="Mobile navigation"
                        >
                            <SidebarNavLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                                icon="pi pi-th-large"
                                @click="closeMobileNav"
                            >
                                Dashboard
                            </SidebarNavLink>
                            <SidebarNavLink
                                :href="route('blogs.index')"
                                :active="route().current('blogs.*')"
                                icon="pi pi-file-edit"
                                @click="closeMobileNav"
                            >
                                Blog
                            </SidebarNavLink>
                            <SidebarNavLink
                                :href="route('testimonials.index')"
                                :active="route().current('testimonials.*')"
                                icon="pi pi-comments"
                                @click="closeMobileNav"
                            >
                                Testimonials
                            </SidebarNavLink>
                            <SidebarNavLink
                                :href="route('educators.index')"
                                :active="route().current('educators.*')"
                                icon="pi pi-users"
                                @click="closeMobileNav"
                            >
                                Educators
                            </SidebarNavLink>
                        </nav>
                        <div class="border-t border-white/10 p-4">
                            <Dropdown
                                align="right"
                                width="48"
                                :content-classes="userMenuContentClass"
                                :drop-up="true"
                            >
                                <template #trigger>
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between gap-2 rounded-xl bg-white/5 px-3 py-3 text-start text-sm text-slate-200 ring-1 ring-white/10"
                                    >
                                        <span class="truncate">{{
                                            $page.props.auth.user.name
                                        }}</span>
                                        <svg
                                            class="h-4 w-4 shrink-0 opacity-70"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink
                                        :href="route('profile.edit')"
                                        @click="closeMobileNav"
                                    >
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </aside>
                </Transition>

                <header
                    v-if="$slots.header"
                    class="border-b border-slate-200/90 bg-white/95 px-6 py-8 shadow-sm backdrop-blur-sm dark:border-slate-700/80 dark:bg-slate-900/80 sm:px-8 lg:px-10"
                >
                    <slot name="header" />
                </header>

                <main class="flex-1">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
