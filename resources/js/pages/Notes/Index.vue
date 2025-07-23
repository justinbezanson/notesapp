<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue'

const props = defineProps(['notes'])

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
</script>

<template>
    <Head title="Notes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-3">
            <div class="">
                <div 
                    v-for="note in props.notes.data"
                    :key="note.id"
                    class="border border-sidebar-border/70 dark:border-sidebar-border rounded m-1 py-2 px-2"
                >
                    <div class="">
                        <div class="space-x-2">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                <strong>{{ note.title }}</strong>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ new Date(note.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                        </div>
                        <div class="space-x-2 text-sm">
                            {{ note.content}}
                        </div>  
                    </div>
                </div>
                <div class="ml-1">
                <Pagination :links="props.notes.links" :currentpage="props.notes.current_page" :lastpage="props.notes.last_page" />
                </div>
            </div>
            <div class="col-span-2 mt-2 ml-2">
                Hello
            </div>
        </div>
    </AppLayout>
</template>