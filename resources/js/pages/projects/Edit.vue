<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import type { Project } from '@/types/project';

const props = defineProps<{
    project: Project;
}>();

const form = useForm({
    title: props.project.title,
    description: props.project.description,
});

const submit = () => {
    form.put(route('projects.update', props.project.id));
};
</script>

<template>
    <Head :title="'Edit ' + project.title" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">Edit {{ project.title }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit project</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit">
                            <div class="grid gap-4">
                                <div>
                                    <label for="title">Title</label>
                                    <Input id="title" v-model="form.title" />
                                    <InputError :message="form.errors.title" />
                                </div>
                                <div>
                                    <label for="description">Description</label>
                                    <QuillEditor theme="snow" v-model:content="form.description" contentType="html" />
                                    <InputError :message="form.errors.description" />
                                    <Button type="submit" :disabled="form.processing"> Update Project </Button>
                                </div>
                            
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
