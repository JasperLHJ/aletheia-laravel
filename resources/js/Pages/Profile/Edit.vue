<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    Profile
                </h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400">
                    Account details and security settings.
                </p>
            </div>
        </template>

        <div class="px-4 py-10 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl space-y-8">
                <div
                    class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60 sm:p-10"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60 sm:p-10"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="rounded-xl border border-slate-200/90 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60 sm:p-10"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
