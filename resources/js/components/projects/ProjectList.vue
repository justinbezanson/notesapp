<template>
    <div class="m-3 mb-0 border-b text-center pb-3">
        <div class="mb-3">
            <input
                v-model="search"
                type="text"
                placeholder="Search projects..."
                class="mr-1 w-full rounded-md border border-gray-100 p-1 focus:border-indigo-500 focus:ring-indigo-500"
            />
            <div class="relative"><Search class="absolute top-0 right-2 opacity-30" style="margin-top: -28px;" /></div>
        </div>

        <div>
            <AppButton @click="$inertia.visit('/projects/create')" class="cursor-pointer w-full">
                <FilePlus2 /> Add Project
            </AppButton>
        </div>
    </div>

    <div v-for="project in projects.data" :key="project.id" class="ml-3 mr-3 border-b border-sidebar-border/70 px-2 py-2 dark:border-sidebar-border">
        <div class="space-x-2">
            <div class="text-sm font-medium text-gray-900 dark:text-white">
                <div class="lg:flex lg:items-center lg:space-x-2">
                    <div class="lg:w-3/4">
                        <a :href="`/projects/${project.id}`" class="hover:text-indigo-600 hover:underline">
                            <strong>{{ project.title }}</strong>
                        </a>
                    </div>
                    <div class="lg:w-1/4 lg:text-right lg:align-top">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ new Date(project.created_at).toLocaleDateString() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0">
        <div class="flex justify-center mt-3 ml-3 mr-3">
            <Pagination :links="projects.links" :currentpage="projects.current_page" :lastpage="projects.last_page" />
        </div>
    </div>
</template>

<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import AppButton from '@/components/ui/button/Button.vue';
import { FilePlus2, Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'

defineProps({
    projects: {
        type: Object as () => {
            data: Array<{
                id: number;
                title: string;
                description: string;
                created_at: string;
            }>;
            links: Array<{ url: string | null; label: string; active?: boolean }>;
            current_page: number;
            last_page: number;
        },
        required: true,
    },
});

const search = ref('');
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

watch(search, (newValue) => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    searchTimeout = setTimeout(() => {
        router.get(window.location.href, { search: newValue }, {
            preserveState: true,
            replace: true
        });
    }, 1000);
});
</script>
