<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';

defineProps({
    projects: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Projects',
        href: '/projects',
    },
];

const form = useForm({});

const deleteProject = (project: any) => {
    if (confirm('Are you sure you want to delete this project?')) {
        form.delete(route('projects.destroy', project));
    }
};
</script>

<template>
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>
                            <div class="grid grid-cols-2 gap-2">
                                <div>Your Projects</div>
                                <div class="text-right">
                                    <Button @click="$inertia.visit('/projects/create')" class="cursor-pointer">
                                        Create Project
                                    </Button>
                                </div>
                            </div>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div v-if="projects && projects.data && projects.data.length > 0" class="grid gap-4">
                            <div v-for="project in projects.data" :key="project.id" class="border p-4 rounded-lg flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold">
                                        <Link :href="route('projects.show', project)">{{ project.title }}</Link>
                                    </h3>
                                    <p class="text-gray-600">{{ project.description }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <Button as-child variant="outline">
                                        <Link :href="route('projects.edit', project)">Edit</Link>
                                    </Button>
                                    <Button @click="deleteProject(project)" variant="destructive">
                                        Delete
                                    </Button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p>You don't have any projects yet.</p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
