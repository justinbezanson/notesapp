<script setup lang="ts">
import ProjectList from '@/components/projects/ProjectList.vue';
import ProjectToolbar from '@/components/projects/ProjectToolbar.vue';
import { getShowProjectListStatus } from '@/composables/useShowProjectListStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps(['projects']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Projects',
        href: '/projects',
    },
];

const showProjectList = ref(getShowProjectListStatus());

type FlashType = {
    success?: string | null;
};

const flash = (usePage().props as { flash?: FlashType }).flash;

onMounted(() => {
    if (flash && flash.success !== null && flash.success !== undefined) {
        toast(flash.success, {
            description: 'Your project has been saved successfully.',
        });
    }
});
</script>

<template>
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-4 h-full">
            <div v-if="showProjectList" class="border-r">
                <ProjectList :projects="props.projects" />
            </div>
            <div class="col-span-3 mt-3 ml-3">
                <ProjectToolbar :showProjectList="showProjectList" @update:showProjectList="showProjectList = $event" />
            </div>
        </div>
    </AppLayout>
</template>
