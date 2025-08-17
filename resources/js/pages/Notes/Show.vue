<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import NoteList from '@/components/Notes/NoteList.vue';
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import { ref } from 'vue';
import { getShowNoteListStatus } from '@/composables/useShowNoteListStatus';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Edit Note',
        href: '/notes/edit',
    },
];

const props = defineProps(['notes', 'note']);

let showNoteList = ref(getShowNoteListStatus());

const form = useForm({
    title: props.note.title,
    content: props.note.content,
});

const saveNote = async () => {
    form.post(route('notes.update', { note: props.note.id, title: form.title, content: form.content }));
};

const deleteNote = async () => {
    if (confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
        form.delete(route('notes.destroy', { note: props.note.id }));
    }
};
</script>

<template>
    <Head title="Edit Note" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-3">
            <div v-if="showNoteList">
                <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-2 mt-1 ml-0 mr-1">
                <div class="m-2 text-lg font-medium text-gray-900 dark:text-white">
                    <NoteToolbar :showNoteList="showNoteList" @update:showNoteList="showNoteList = $event" />
                    Edit a note
                </div>
                <div>
                    <input
                        type="text"
                        class="mb-2 w-full rounded-md border border-gray-100 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Note Title"
                        v-model="form.title"
                    />
                </div>
                <QuillEditor theme="snow" v-model:content="form.content" contentType="html" />

                <div class="mt-2">
                    <Button @click="saveNote" class="cursor-pointer">Save Note</Button>
                    <Button @click="deleteNote" variant="destructive" class="cursor-pointer ml-2">Delete Note</Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.ql-toolbar {
    border: 1px solid #f3f4f6 !important; /*border-gray-100*/
    border-top-left-radius: 0.375rem; /* Tailwind rounded-md */
    border-top-right-radius: 0.375rem; /* Tailwind rounded-md */
}

.ql-container {
    border: 1px solid #f3f4f6 !important; /*border-gray-100*/
    border-bottom-left-radius: 0.375rem; /* Tailwind rounded-md */
    border-bottom-right-radius: 0.375rem; /* Tailwind rounded-md */
    border-top-width: 0 !important;
}
</style>
