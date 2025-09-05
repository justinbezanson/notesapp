<script lang="ts">
import { ChevronsLeft, ChevronsRight, Save, Trash2 } from 'lucide-vue-next';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';

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
        onDelete: {
            type: Function,
            required: false,
        },
    },

    name: 'NotesToolbar',
    components: {
        ChevronsLeft,
        ChevronsRight,
        Save,
        Trash2,
        AlertDialog,
        AlertDialogAction,
        AlertDialogCancel,
        AlertDialogContent,
        AlertDialogDescription,
        AlertDialogFooter,
        AlertDialogHeader,
        AlertDialogTitle,
        AlertDialogTrigger,
        Button,
    },
    emits: ['update:showNoteList', 'save'],
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
            <Button variant="link" size="icon"
                @click="toggleShowNoteList"
                :title="showNoteList ? 'Hide Note List' : 'Show Note List'"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700 hidden lg:block"
            >
                <ChevronsLeft v-if="showNoteList" title="Hide Note List" class="h-4 w-4" />
                <ChevronsRight v-else title="Show Note List" class="h-4 w-4" />
            </Button>
            <Button variant="link" size="icon"
                v-if="showSave"
                @click="$emit('save')"
                title="Save Note"
                class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
            >
                <Save class="h-4 w-4" />
            </Button>
            <div v-if="showDelete">
                <AlertDialog>
                    <AlertDialogTrigger as-child>
                        <Button variant="link" size="icon" class="mb-1 cursor-pointer rounded-sm border-1 border-white p-2 text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">
                            <Trash2 class="h-3 w-3" />
                        </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will permanently delete your note.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction @click="onDelete">Continue</AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </div>
    </div>
</template>

<style></style>
