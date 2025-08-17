<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import NoteList from '@/components/Notes/NoteList.vue';
import Button from '@/components/ui/button/Button.vue';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import { toast } from "vue-sonner"
import { onMounted, ref } from 'vue';
import { getShowNoteListStatus } from '@/composables/useShowNoteListStatus';
    
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

let showNoteList = ref(getShowNoteListStatus());

type FlashType = {
    success?: string | null;
};

const flash = (usePage().props as { flash?: FlashType }).flash;

onMounted(() => {
    if (flash && flash.success !== null && flash.success !== undefined) {
        toast(flash.success, {
            description: 'Your note has been saved successfully.'
        });
    }
});

</script>

<template>
    <Head title="Notes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-3">
            <div v-if="showNoteList">
                <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-2 mt-2 ml-2">
                <NoteToolbar :showNoteList="showNoteList" @update:showNoteList="showNoteList = $event" />
                <Button @click="$inertia.visit('/notes/create')" class="cursor-pointer">
                    Create Note
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
