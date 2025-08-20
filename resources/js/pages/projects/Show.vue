<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

defineProps({
    project: Object,
});
</script>

<template>
    <Head :title="project.title" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ project.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>{{ project.title }}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p>{{ project.description }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
