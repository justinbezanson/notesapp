<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref } from 'vue';
import NoteList from '@/components/Notes/NoteList.vue';

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

const content = ref<string>('');
const props = defineProps(['notes']);
</script>

<template>
    <Head title="Create Note" />
    <AppLayout :breadcrumbs="breadcrumbs" title="Create Note">
        <div class="grid grid-cols-3">
            <div>
            <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-2 mt-2 ml-2">
                <QuillEditor theme="snow" v-model="content" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
