<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

import type { Project } from '@/types/project';

defineProps<{
    project: Project;
}>();
</script>

<template>
    <Head :title="project.title" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">
                {{ project.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
