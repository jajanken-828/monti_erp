<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {
    Users,
    UserPlus,
    Calendar,
    TrendingUp,
    Clock,
    CheckCircle2,
    MoreHorizontal,
    Search,
    Filter
} from 'lucide-vue-next'

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalEmployees: 0,
            activeRecruitment: 0,
            pendingLeaves: 0,
            attendanceRate: 0
        })
    }
})

// Mock data for the table based on your blade design
const recentStaff = [
    { id: 'MT-001', name: 'Alexander Wright', position: 'Senior Weaver', department: 'Production', status: 'Active', joinDate: 'Jan 12, 2024' },
    { id: 'MT-002', name: 'Sarah Jenkins', position: 'Quality Inspector', department: 'Quality Control', status: 'Active', joinDate: 'Jan 15, 2024' },
    { id: 'MT-003', name: 'Michael Chen', position: 'Shift Supervisor', department: 'Operations', status: 'On Leave', joinDate: 'Feb 01, 2024' },
];

const getStatusClass = (status) => {
    return status === 'Active'
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
        : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
}
</script>

<template>

    <Head title="HRM Manager Dashboard" />

    <AuthenticatedLayout>
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">HRM Manager Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400">Welcome back! Here's what's happening with your workforce today.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <Users class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">+4%</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Employees</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.totalEmployees }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                        <UserPlus class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">12 Open</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Applicants</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.activeRecruitment }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                        <Calendar class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Action
                        Required</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Leaves</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.pendingLeaves }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                        <TrendingUp class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Optimal</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Attendance Rate</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.attendanceRate }}%</p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div
                class="p-6 border-b border-gray-50 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Hires & Staff</h2>
                    <p class="text-sm text-gray-500">Overview of the latest additions to your team.</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <input type="text" placeholder="Search staff..."
                            class="pl-9 pr-4 py-2 text-sm border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none w-full" />
                    </div>
                    <button
                        class="p-2 border border-gray-200 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <Filter class="h-4 w-4 text-gray-500" />
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-900/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Employee
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Position
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Department
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Join Date
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        <tr v-for="staff in recentStaff" :key="staff.id"
                            class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors group">
                            <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ staff.id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs mr-3">
                                        {{staff.name.split(' ').map(n => n[0]).join('')}}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ staff.name
                                        }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ staff.position
                                }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ staff.department }}</td>
                            <td class="px-6 py-4">
                                <span :class="getStatusClass(staff.status)"
                                    class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider">
                                    {{ staff.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ staff.joinDate }}</td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="p-2 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-100">
                                    <MoreHorizontal class="h-4 w-4 text-gray-400" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="px-6 py-4 bg-gray-50/30 dark:bg-gray-900/30 border-t border-gray-50 dark:border-gray-700 text-xs font-bold text-gray-400 uppercase tracking-widest flex justify-between items-center">
                <span>Updated every 5 minutes</span>
                <button class="text-blue-600 hover:text-blue-700">View Full Directory</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>