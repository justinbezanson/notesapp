<template>
    <div v-if="links.length > 3">
        <div class="mb-1 flex flex-wrap" :class="cssclass">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="mr-1 mb-1 rounded border px-4 py-3 text-sm leading-4 text-gray-400"
                    v-html="link.label"
                ></div>
                <InertiaLink
                    v-else
                    :key="`link-${key}`"
                    preserve-scroll
                    class="mr-1 mb-1 rounded border px-4 py-3 text-sm leading-4 hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500"
                    :class="{
                        'bg-white': link.active,
                        'font-bold': currentpage?.toString() == link.label,
                        'text-indigo-500': currentpage?.toString() == link.label,
                    }"
                    :href="link.url"
                >
                    <span v-html="link.label"></span>
                </InertiaLink>
            </template>
        </div>
    </div>
</template>

<script lang="ts">
import { Link as InertiaLink } from '@inertiajs/vue3';

type LinkType = {
    url: string | null;
    label: string;
    active?: boolean;
};

export default {
    components: {
        InertiaLink,
    },
    props: {
        links: {
            type: Array as () => LinkType[],
            default: () => [],
        },
        cssclass: String,
        currentpage: Number,
        lastpage: Number,
    },
};
</script>