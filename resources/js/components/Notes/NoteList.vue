<template>
    <div class="m-3 pb-0 text-center border-b pb-3">
        <div class="mb-3">
            <input
                type="text"
                placeholder="Search notes..."
                class="mr-1 w-full rounded-md border border-gray-100 p-1 focus:border-indigo-500 focus:ring-indigo-500"
            />
            <div class="relative"><Search class="absolute top-0 right-2 opacity-30" style="margin-top: -28px;" /></div>
        </div>

        <div>
            <Button @click="$inertia.visit('/notes/create')" class="cursor-pointer w-full">
                <FilePlus2 /> Add Note
            </Button>
        </div>
    </div>
    <div v-for="note in notes.data" :key="note.id" class="m-3 border-b border-sidebar-border/70 px-2 py-2 dark:border-sidebar-border">
        <div class="">
            <div class="space-x-2">
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    <div class="lg:flex lg:items-center lg:space-x-2">
                        <div class="lg:w-3/4">
                            <a :href="`/notes/${note.id}`" class="hover:text-indigo-600 hover:underline">
                                <strong>{{ note.title }}</strong>
                            </a>
                        </div>
                        <div class="lg:w-1/4 lg:text-right lg:align-top">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ new Date(note.created_at).toLocaleDateString() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-x-2 text-sm" v-html="note.content_limited"></div>
        </div>
    </div>
    <div class="flex justify-center">
        <Pagination :links="notes.links" :currentpage="notes.current_page" :lastpage="notes.last_page" />
    </div>
</template>

<script lang="ts">
import Pagination from '@/components/Pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { FilePlus2, Search } from 'lucide-vue-next';

export default {
    components: {
        Pagination,
        Button,
        FilePlus2,
        Search
    },
    props: {
        notes: {
            type: Object as () => {
                data: Array<{
                    id: number;
                    title: string;
                    content: string;
                    created_at: string;
                    content_limited: string;
                }>;
                links: Array<{ url: string | null; label: string; active?: boolean }>;
                current_page: number;
                last_page: number;
            },
            required: true,
        },
    },
};
</script>
