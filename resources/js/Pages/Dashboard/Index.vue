<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    stats: Object,
    user: Object
})
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Welcome to Your Dashboards
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Manage your operations efficiently
            </p>
        </div>

        <!-- Generic stats for all users -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Tasks</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats?.total_tasks || 0 }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">Pending Tasks</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats?.pending_tasks || 0 }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">Completed Tasks</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats?.completed_tasks || 0 }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">Your Role</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white capitalize">
                    {{ user?.position || 'User' }}
                </p>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                <h3 class="text-lg font-semibold mb-2">HRM Department</h3>
                <p class="mb-4">Manage employees, recruitment, and HR operations</p>
                <a :href="route('hrm.employee.dashboard')"
                    class="inline-block bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    Go to HRM Dashboard
                </a>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
                <h3 class="text-lg font-semibold mb-2">SCM Department</h3>
                <p class="mb-4">Manage inventory, supply chain, and logistics</p>
                <a :href="route('scm.employee.dashboard')"
                    class="inline-block bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                    Go to SCM Dashboard
                </a>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
                <h3 class="text-lg font-semibold mb-2">Profile Settings</h3>
                <p class="mb-4">Update your personal information and preferences</p>
                <a :href="route('profile.edit')"
                    class="inline-block bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>