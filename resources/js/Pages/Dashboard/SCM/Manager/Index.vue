<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from '@/Components/dashboard/StatsCard.vue';
import { Boxes, Package, Truck, AlertTriangle } from 'lucide-vue-next';

// Define the props passed from the Controller
const props = defineProps({
    stats: Object,
    inventoryItems: Array,
    pendingOrders: Array
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">SCM Management Dashboard</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <StatCard title="Total Inventory" :value="stats.totalInventory" :icon="Boxes" />
            <StatCard title="Pending Orders" :value="stats.pendingOrders" :icon="Package" />
            <StatCard title="Stock Alerts" :value="stats.stockAlerts" :icon="AlertTriangle"
                colorClass="text-rose-600 bg-rose-50 dark:bg-rose-900/20" />
        </div>
    </AuthenticatedLayout>
</template>