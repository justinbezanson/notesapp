<template>
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <a 
                @click="() => page.props.showNoteList = !page.props.showNoteList" 
                :title="page.props.showNoteList ? 'Hide Note List' : 'Show Note List'"
                class="cursor-pointer text-gray-500 hover:text-gray-700 border-1 border-white hover:border-gray-300 hover:bg-gray-50 rounded-sm mb-1"
            >
            <ChevronsLeft v-if="page.props.showNoteList" title="Hide Note List" />
            <ChevronsRight v-else title="Show Note List" />
            </a>
        </div>
        <div class="flex items-center">
            
        </div>
    </div>
</template>

<script lang="ts">
import { ChevronsLeft, ChevronsRight } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

export default {
    data() {
        return {
            page: usePage(),
        };
    },

    name: 'NotesToolbar',
    components: {
        ChevronsLeft,
        ChevronsRight,
    },
};
</script>

<style>

</style>