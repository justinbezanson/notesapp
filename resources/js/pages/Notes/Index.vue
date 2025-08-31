<script setup lang="ts">
import NoteList from '@/components/Notes/NoteList.vue';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import { getShowNoteListStatus } from '@/composables/useShowNoteListStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps(['notes']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Notes',
        href: '/notes',
    },
];

const showNoteList = ref(getShowNoteListStatus());

type FlashType = {
    success?: string | null;
};

const flash = (usePage().props as { flash?: FlashType }).flash;

onMounted(() => {
    if (flash && flash.success !== null && flash.success !== undefined) {
        toast(flash.success, {
            description: 'Your note has been saved successfully.',
        });
    }
});
</script>

<template>
    <Head title="Notes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-4 h-full">
            <div v-if="showNoteList" class="border-r">
                <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-3 mt-3 ml-3">
                <NoteToolbar :showNoteList="showNoteList" @update:showNoteList="showNoteList = $event" />
            </div>
        </div>
    </AppLayout>
</template>
