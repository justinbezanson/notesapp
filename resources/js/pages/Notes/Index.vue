<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import NoteList from '@/components/Notes/NoteList.vue';
import Button from '@/components/ui/button/Button.vue';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import { toast } from "vue-sonner"
import { onMounted } from 'vue';

//TODO: toast needs work so it doesn't show on page refresh
//TODO: showNotelist needs to be sent to server to update sesssion var or switch to local storage
    
const props = defineProps(['notes', 'successMessage']);

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

onMounted(() => {
    if (props?.successMessage !== null) {
        toast(props.successMessage, {
            description: 'Your note has been saved successfully.'
        });
    }
});

</script>

<template>
    <Head title="Notes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-3">
            <div v-if="usePage().props.showNoteList">
                <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-2 mt-2 ml-2">
                <NoteToolbar />
                <Button @click="$inertia.visit('/notes/create')" class="cursor-pointer">
                    Create Note
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
