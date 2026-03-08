<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Items & Species' },
];

const items = ref<any[]>([]);

onMounted(async () => {
    const response = await fetch('/api/items');
    items.value = await response.json();
});
</script>

<template>
    <Head title="Items & Species" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <h1 class="text-2xl font-bold">Items & Species</h1>

            <div class="rounded-lg border overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-muted/50">
                            <th class="px-4 py-3 text-left font-medium">ID</th>
                            <th class="px-4 py-3 text-left font-medium">Scientific Name</th>
                            <th class="px-4 py-3 text-left font-medium">Species</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.id" class="border-b">
                            <td class="px-4 py-3">{{ item.id }}</td>
                            <td class="px-4 py-3">{{ item.scientific_name }}</td>
                            <td class="px-4 py-3">{{ item.species?.name || '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
