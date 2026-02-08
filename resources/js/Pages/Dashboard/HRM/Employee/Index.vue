<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// props expected from the Controller
const props = defineProps({
    auth: Object,
    employees: Array, // Array of employee objects
    stats: Object     // e.g., { total: 45, present: 38, on_leave: 4 }
});

// Search and Filter Logic
const search = ref('');

const getStatusClass = (status) => {
    const classes = {
        'Active': 'bg-green-100 text-green-800',
        'On Leave': 'bg-yellow-100 text-yellow-800',
        'Remote': 'bg-blue-100 text-blue-800',
        'Inactive': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>

    <Head title="Employee Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Employee Management
                </h2>
                <Link href="/employees/create"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                    + Add New Employee
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Workforce</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ stats?.total ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 uppercase">Currently Clocked In</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ stats?.present ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 uppercase">On Leave</p>
                        <h3 class="text-2xl font-bold text-yellow-600">{{ stats?.on_leave ?? 0 }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500 uppercase">Open Positions</p>
                        <h3 class="text-2xl font-bold text-blue-600">5</h3>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <h3 class="text-lg font-bold text-gray-900">All Employees</h3>
                            <div class="relative">
                                <input v-model="search" type="text" placeholder="Search employees..."
                                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                                <div class="absolute left-3 top-2.5 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Employee
                                    </th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Department</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="employee in employees" :key="employee.id"
                                    class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                                                {{ employee.name.charAt(0) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ employee.name }}</div>
                                                <div class="text-sm text-gray-500">{{ employee.email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ employee.department }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ employee.role }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            :class="`px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusClass(employee.status)}`">
                                            {{ employee.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="route('employees.edit', employee.id)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                                        <button class="text-red-600 hover:text-red-900">Archive</button>
                                    </td>
                                </tr>
                                <tr v-if="!employees?.length">
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No employees found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <p class="text-xs text-gray-500">Showing {{ employees?.length ?? 0 }} employees</p>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 border rounded text-xs disabled:opacity-50">Previous</button>
                            <button class="px-3 py-1 border rounded text-xs disabled:opacity-50">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>