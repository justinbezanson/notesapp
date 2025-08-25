<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a
                @click="toggleShowNoteList"
                :title="showNoteList ? 'Hide Note List' : 'Show Note List'"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
            >
                <ChevronsLeft v-if="showNoteList" title="Hide Note List" />
                <ChevronsRight v-else title="Show Note List" />
            </a>
        </div>
        <div class="flex items-center"></div>
    </div>
</template>

<script lang="ts">
import { ChevronsLeft, ChevronsRight } from 'lucide-vue-next';

export default {
    props: {
        showNoteList: {
            type: Boolean,
            required: true,
        },
    },

    name: 'NotesToolbar',
    components: {
        ChevronsLeft,
        ChevronsRight,
    },
    methods: {
        toggleShowNoteList() {
            const newValue = !this.showNoteList;
            this.$emit('update:showNoteList', newValue);
            localStorage.setItem('showNoteList', newValue.toString());
        },
    },
};
</script>

<style></style>
