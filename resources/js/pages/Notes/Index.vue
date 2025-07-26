<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import NoteList from '@/components/Notes/NoteList.vue';
import Button from '@/components/ui/button/Button.vue';

const props = defineProps(['notes']);

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
            <div>
            <NoteList :notes="props.notes" />
            </div>
            <div class="col-span-2 mt-2 ml-2">
                <Button @click="$inertia.visit('/notes/create')" class="cursor-pointer">
                    Create Note
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
