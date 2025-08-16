<template>
    <div
        v-for="note in notes.data"
        :key="note.id"
        class="m-1 rounded border border-sidebar-border/70 px-2 py-2 dark:border-sidebar-border"
    >
        <div class="">
            <div class="space-x-2">
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    <div class="flex items-center space-x-2">
                        <div class="w-3/4">
                            <a :href="`/notes/${note.id}`" class="hover:text-indigo-600 hover:underline">
                                <strong>{{ note.title }}</strong>
                            </a>
                        </div>
                        <div class="w-1/4 text-right">
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
    <div class="ml-1">
        <Pagination :links="notes.links" :currentpage="notes.current_page" :lastpage="notes.last_page" />
    </div>
</template>

<script lang="ts">
import Pagination from '@/components/Pagination.vue';

export default {
    components: {
        Pagination,
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