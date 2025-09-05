<script setup lang="ts">
import NoteList from '@/components/Notes/NoteList.vue';
import NoteToolbar from '@/components/Notes/NotesToolbar.vue';
import { getShowNoteListStatus } from '@/composables/useShowNoteListStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Create Note',
        href: '/notes/create',
    },
];

const props = defineProps(['notes']);

const showNoteList = ref(getShowNoteListStatus());

const form = useForm({
    title: '',
    content: '',
});

const saveNote = async () => {
    form.post(route('notes.store'));
};
</script>

<template>
    <Head title="Create Note" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-1 lg:grid-cols-4 h-full">
            <div v-if="showNoteList" class="lg:col-span-1 hidden lg:block border-r">
                <NoteList :notes="props.notes" />
            </div>
            <div class="lg:col-span-3 col-span-full pt-3 mt-0 mr-3 ml-3 pb-8 h-full flex flex-col">
                <NoteToolbar
                    :showNoteList="showNoteList"
                    @update:showNoteList="showNoteList = $event"
                    :show-save="true"
                    @save="saveNote"
                />
                <div>
                    <input
                        type="text"
                        class="mb-2 w-full rounded-md border border-gray-100 p-2 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Note Title"
                        v-model="form.title"
                    />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <div class="flex-1">
                    <QuillEditor theme="snow" v-model:content="form.content" contentType="html" />
                    <InputError :message="form.errors.content" class="mt-2" />
                </div>

                <div>&nbsp;</div>
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
