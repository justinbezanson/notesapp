<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a
                @click="toggleShowProjectList"
                :title="showProjectList ? 'Hide Project List' : 'Show Project List'"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
            >
                <ChevronsLeft v-if="showProjectList" title="Hide Project List" />
                <ChevronsRight v-else title="Show Project List" />
            </a>
        </div>
        <div class="flex items-center"></div>
    </div>
</template>

<script lang="ts">
import { ChevronsLeft, ChevronsRight } from 'lucide-vue-next';

export default {
    props: {
        showProjectList: {
            type: Boolean,
            required: true,
        },
    },

    name: 'ProjectToolbar',
    components: {
        ChevronsLeft,
        ChevronsRight,
    },
    methods: {
        toggleShowProjectList() {
            const newValue = !this.showProjectList;
            this.$emit('update:showProjectList', newValue);
            localStorage.setItem('showProjectList', newValue.toString());
        },
    },
};
</script>

<style></style>
