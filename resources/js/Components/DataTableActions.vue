<script setup>
import Button from 'primevue/button';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    viewRoute: { type: String, required: true },
    editRoute: { type: String, required: true },
    deleteRoute: { type: String, required: true },
    itemId: { type: [Number, String], required: true },
    itemName: { type: String, default: 'this item' },
});

const view = () => router.visit(props.viewRoute);
const edit = () => router.visit(props.editRoute);
const remove = () => {
    if (confirm(`Are you sure you want to delete ${props.itemName}?`)) {
        router.delete(props.deleteRoute);
    }
};
</script>

<template>
    <div class="flex flex-wrap items-center gap-1">
        <Button
            icon="pi pi-eye"
            severity="secondary"
            text
            rounded
            title="View"
            @click="view"
        />
        <Button
            icon="pi pi-pencil"
            severity="secondary"
            text
            rounded
            title="Edit"
            @click="edit"
        />
        <Button
            icon="pi pi-trash"
            severity="danger"
            text
            rounded
            title="Delete"
            @click="remove"
        />
    </div>
</template>
