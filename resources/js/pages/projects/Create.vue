<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const form = useForm({
    title: '',
    description: '',
});

const submit = () => {
    form.post(route('projects.store'));
};
</script>

<template>
    <Head title="Create Project" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">Create Project</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Create a new project</CardTitle>
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
                                    <Button type="submit" :disabled="form.processing"> Create Project </Button>
                                </div>
                                
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
