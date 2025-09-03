<script setup lang="ts">
import NoteList from '@/components/Notes/NoteList.vue';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import Button from '@/components/ui/button/Button.vue';
import { getShowNoteListStatus } from '@/composables/useShowNoteListStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref } from 'vue';

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

const showNoteList = ref(getShowNoteListStatus());

const form = useForm({
    title: props.note.title,
    content: props.note.content,
});

const saveNote = async () => {
    form.put(route('notes.update', { note: props.note.id, title: form.title, content: form.content }));
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
        <div class="grid grid-cols-1 lg:grid-cols-4 h-full">
            <div v-if="showNoteList" class="lg:col-span-1 hidden lg:block border-r">
                <NoteList :notes="props.notes" />
            </div>
            <div class="lg:col-span-3 col-span-full pt-3 mt-0 mr-3 ml-3 h-full flex flex-col">
                <NoteToolbar :showNoteList="showNoteList" @update:showNoteList="showNoteList = $event" />
                <div>
                    <input
                        type="text"
                        class="mb-2 w-full rounded-md border border-gray-100 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Note Title"
                        v-model="form.title"
                    />
                </div>

                <div class="flex-1">
                    <QuillEditor theme="snow" v-model:content="form.content" contentType="html" />
                </div>
                <div class="mt-14 mb-3">
                    <Button @click="saveNote" class="cursor-pointer">Save Note</Button>
                    <Button @click="deleteNote" variant="destructive" class="ml-2 cursor-pointer">Delete Note</Button>
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
