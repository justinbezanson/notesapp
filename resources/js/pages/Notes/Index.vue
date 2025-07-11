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
            <div class="border-r border-t border-sidebar-border/70 dark:border-sidebar-border rounded-r mt-2">
                <div 
                    v-for="note in props.notes.data"
                    :key="note.id"
                    class="border-b border-sidebar-border/70 dark:border-sidebar-border last:border-b-0 py-4 px-4"
                >
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                <strong>{{ note.title }}</strong>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ note.created_at }}
                                </span>
                                
                                
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ note.content}}
                        </div>  
                    </div>
                </div>
                <Pagination :links="props.notes.links" class="mb-4" />
            </div>
            <div class="col-span-2 mt-2 ml-2">
                Hello
            </div>
        </div>
    </AppLayout>
</template>