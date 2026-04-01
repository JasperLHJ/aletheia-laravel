<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <p class="mb-6 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
            Thanks for signing up! Before getting started, verify your email
            using the link we sent. If you did not receive the email, we will
            send another.
        </p>

        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-200"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-center text-sm text-slate-600 underline hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:text-slate-400 dark:hover:text-slate-200 dark:focus:ring-offset-slate-900 sm:text-end"
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
