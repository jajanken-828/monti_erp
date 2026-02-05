<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    stats: Object
})
</script>

<template>

    <Head title="HRM Manager Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            HRM Manager Dashboard
        </template>

        <template #subheader>
            Manage your HR team and operations
        </template>

        <!-- Your existing stats and content here -->
        <div class="space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.totalEmployees }}</p>
                </div>
                <!-- ... other stat cards -->
            </div>

            <!-- Content cards -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
                <!-- Your quick actions here -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>