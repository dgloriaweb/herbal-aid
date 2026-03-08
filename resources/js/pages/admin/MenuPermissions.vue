<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { onMounted, ref, computed, reactive } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Admin', href: '/admin' },
    { title: 'Menu Permissions' },
];

const page = usePage();
const flash = computed(() => page.props.flash as { success?: string; error?: string } | undefined);

const roles = ref<any[]>([]);
const menuItems = ref<any[]>([]);
const selectedPermissions = reactive<Set<string>>(new Set());

onMounted(async () => {
    await loadData();
});

async function loadData() {
    const [rolesData, itemsData, permsData] = await Promise.all([
        fetch('/api/roles').then(r => r.json()),
        fetch('/api/menu-items').then(r => r.json()),
        fetch('/api/menu-permissions').then(r => r.json()),
    ]);
    
    roles.value = rolesData;
    menuItems.value = itemsData.filter((item: any) => item.parent_id !== null);
    
    permsData.forEach((perm: any) => {
        selectedPermissions.add(`${perm.menu_item_id}_${perm.role_id}`);
    });
}

function isChecked(menuItemId: number, roleId: number): boolean {
    return selectedPermissions.has(`${menuItemId}_${roleId}`);
}

function togglePermission(menuItemId: number, roleId: number, checked: boolean) {
    const key = `${menuItemId}_${roleId}`;
    console.log('Toggle called:', key, checked);
    if (checked) {
        selectedPermissions.add(key);
    } else {
        selectedPermissions.delete(key);
    }
    console.log('Current permissions:', Array.from(selectedPermissions));
}

function savePermissions() {
    const permissionsData = Array.from(selectedPermissions).map(key => {
        const [menuItemId, roleId] = key.split('_');
        return {
            menu_item_id: parseInt(menuItemId),
            role_id: parseInt(roleId),
        };
    });
    
    router.post('/api/menu-permissions', { permissions: permissionsData }, { 
        preserveScroll: true,
        onSuccess: () => alert('Saved!'),
        onError: () => alert('Error!'),
    });
}
</script>

<template>
    <Head title="Menu Permissions" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div>
                <h1 class="text-2xl font-bold">Menu Permissions Matrix</h1>
                <p class="text-sm text-muted-foreground">Configure which roles can access which menu items</p>
            </div>

            <div class="rounded-lg border overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-muted/50">
                            <th class="px-4 py-3 text-left font-medium">Menu Item</th>
                            <th class="px-4 py-3 text-left font-medium">Parent</th>
                            <th v-for="role in roles" :key="role.id" class="px-4 py-3 text-center font-medium">
                                {{ role.name }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in menuItems" :key="item.id" class="border-b">
                            <td class="px-4 py-3 font-medium">{{ item.name }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ item.parent?.name || '-' }}</td>
                            <td v-for="role in roles" :key="role.id" class="px-4 py-3 text-center">
                                <input
                                    type="checkbox"
                                    :checked="isChecked(item.id, role.id)"
                                    @change="(e) => togglePermission(item.id, role.id, (e.target as HTMLInputElement).checked)"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center gap-4">
                <Button @click="savePermissions">Save Permissions</Button>
                <p v-if="flash?.success" class="text-sm font-medium text-green-600">{{ flash.success }}</p>
                <p v-if="flash?.error" class="text-sm font-medium text-red-600">{{ flash.error }}</p>
            </div>
        </div>
    </AppLayout>
</template>
