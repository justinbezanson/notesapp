<script lang="ts">
import { ChevronsLeft, ChevronsRight, Save, Trash2 } from 'lucide-vue-next';

export default {
    props: {
        showNoteList: {
            type: Boolean,
            required: true,
        },
        showSave: {
            type: Boolean,
            default: false,
        },
        showDelete: {
            type: Boolean,
            default: false,
        },
    },

    name: 'NotesToolbar',
    components: {
        ChevronsLeft,
        ChevronsRight,
        Save,
        Trash2,
    },
    emits: ['update:showNoteList', 'save', 'delete'],
    methods: {
        toggleShowNoteList() {
            const newValue = !this.showNoteList;
            this.$emit('update:showNoteList', newValue);
            localStorage.setItem('showNoteList', newValue.toString());
        },
    },
};
</script>

<template>
    <div class="flex items-center">
        <div class="flex items-center">
            <a
                @click="toggleShowNoteList"
                :title="showNoteList ? 'Hide Note List' : 'Show Note List'"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700 hidden lg:block"
            >
                <ChevronsLeft v-if="showNoteList" title="Hide Note List" class="h-4 w-4" />
                <ChevronsRight v-else title="Show Note List" class="h-4 w-4" />
            </a>
            <a
                v-if="showSave"
                @click="$emit('save')"
                title="Save Note"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
            >
                <Save class="h-4 w-4" />
            </a>
            <a
                v-if="showDelete"
                @click="$emit('delete')"
                title="Delete Note"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
            >
                <Trash2 class="h-4 w-4" />
            </a>
        </div>
    </div>
</template>

<style></style>
