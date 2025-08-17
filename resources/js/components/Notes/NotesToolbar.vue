<template>
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <a 
                @click="toggleShowNoteList" 
                :title="showNoteList ? 'Hide Note List' : 'Show Note List'"
                class="cursor-pointer text-gray-500 hover:text-gray-700 border-1 border-white hover:border-gray-300 hover:bg-gray-50 rounded-sm mb-1"
            >
            <ChevronsLeft v-if="showNoteList" title="Hide Note List" />
            <ChevronsRight v-else title="Show Note List" />
            </a>
        </div>
        <div class="flex items-center">
            
        </div>
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
            console.log('Toggling showNoteList:', newValue);
            this.$emit('update:showNoteList', newValue);
            localStorage.setItem('showNoteList', newValue.toString());
            console.log(localStorage.getItem('showNoteList'));
        }
    }
};
</script>

<style>

</style>