<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatsCard from '@/Components/dashboard/StatsCard.vue';
import { Truck, PackageSearch, ClipboardCheck } from 'lucide-vue-next';

const props = defineProps({
    stats: Object,
    user: Object
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">SCM Operations Portal</h2>
            <p class="text-gray-500 dark:text-gray-400">Welcome, {{ user.name }}. Manage your logistics tasks here.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <StatsCard title="Pending Pickups" :value="stats.pendingPickups" :icon="Truck"
                colorClass="text-blue-600 bg-blue-50 dark:bg-blue-900/20" />
            <StatsCard title="Shipments Due" :value="stats.incomingShipments" :icon="PackageSearch"
                colorClass="text-orange-600 bg-orange-50 dark:bg-orange-900/20" />
            <StatsCard title="Inventory Checks" :value="stats.inventoryChecks" :icon="ClipboardCheck"
                colorClass="text-cyan-600 bg-cyan-50 dark:bg-cyan-900/20" />
        </div>
    </AuthenticatedLayout>
</template>