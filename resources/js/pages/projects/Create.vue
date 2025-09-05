<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import ProjectList from '@/components/projects/ProjectList.vue';
import ProjectToolbar from '@/components/projects/ProjectToolbar.vue';
import { Button } from '@/components/ui/button';

import { getShowProjectListStatus } from '@/composables/useShowProjectListStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ref } from 'vue';

defineProps<{
    projects: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Projects',
        href: '/projects',
    },
    {
        title: 'Create',
        href: '/projects/create',
    },
];

const showProjectList = ref(getShowProjectListStatus());

const form = useForm({
    title: '',
    description: '',
});

const submit = () => {
    form.post(route('projects.store'));
};
</script>

<template>
    <Head title="Create Project" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-4 h-full">
            <div v-if="showProjectList" class="border-r">
                <ProjectList :projects="projects" />
            </div>
            <div class="col-span-3 pt-3 mt-0 ml-3 mr-3 h-full flex flex-col">
                <ProjectToolbar :showProjectList="showProjectList" @update:showProjectList="showProjectList = $event" />
                <div>
                    <input 
                        id="title" 
                        type="text" 
                        v-model="form.title" 
                        placeholder="Project Title" 
                        class="mb-2 w-full rounded-md border border-gray-100 p-2 focus:border-indigo-500 focus:ring-indigo-500" 
                    />
                    <InputError :message="form.errors.title" />
                </div>
                <div class="flex-1">
                    <QuillEditor theme="snow" v-model:content="form.description" contentType="html" />
                    <InputError :message="form.errors.description" />
                </div>
                <div class="mt-14 mb-3">
                    <Button @click="submit" :disabled="form.processing"> Create Project </Button>
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