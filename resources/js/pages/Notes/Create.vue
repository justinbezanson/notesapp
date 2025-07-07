<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

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

</script>

<template>
    <Head title="Create Note" />
    <AppLayout :breadcrumbs="breadcrumbs" title="Create Note">
        <QuillEditor theme="snow" v-model="content" />
    </AppLayout>
</template>

<style scoped>

</style>