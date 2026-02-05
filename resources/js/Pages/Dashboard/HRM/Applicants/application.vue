<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    Search,
    UserPlus,
    Filter,
    MoreHorizontal,
    Mail,
    FileText,
    CheckCircle2,
    Clock,
    XCircle
} from 'lucide-vue-next';

const props = defineProps({
    applicants: {
        type: Array,
        default: () => [
            { id: 1, name: 'John Doe', email: 'john@example.com', position: 'Weaver', status: 'Interview', date: '2024-02-01' },
            { id: 2, name: 'Jane Smith', email: 'jane@example.com', position: 'Quality Control', status: 'Pending', date: '2024-02-03' },
            { id: 3, name: 'Mike Ross', email: 'mike@example.com', position: 'Floor Manager', status: 'Rejected', date: '2024-01-28' },
        ]
    }
});

const searchQuery = ref('');

const getStatusClass = (status) => {
    switch (status) {
        case 'Interview': return 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
        case 'Hired': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
        case 'Rejected': return 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400';
        default: return 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
    }
};
</script>

<template>

    <Head title="Applicant Management" />

    <AuthenticatedLayout>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Recruitment <span class="text-blue-600">Portal</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Manage and track job applicants for
                    Monti Textile.</p>
            </div>
            <button
                class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                <UserPlus class="h-4 w-4" />
                Add New Applicant
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative md:col-span-2">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                <input v-model="searchQuery" type="text" placeholder="Search applicants by name, email or position..."
                    class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-blue-600 dark:focus:ring-blue-500 transition-all text-sm" />
            </div>
            <button
                class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all">
                <Filter class="h-4 w-4" />
                Advanced Filters
            </button>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Applicant</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Position</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Applied Date</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <tr v-for="person in applicants" :key="person.id"
                            class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ person.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ person.name }}
                                        </p>
                                        <p class="text-xs text-slate-400">{{ person.email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{
                                    person.position }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ person.date }}
                            </td>
                            <td class="px-6 py-4">
                                <span :class="getStatusClass(person.status)"
                                    class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                    {{ person.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all"
                                        title="View CV">
                                        <FileText class="h-4 w-4" />
                                    </button>
                                    <button
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all"
                                        title="Email">
                                        <Mail class="h-4 w-4" />
                                    </button>
                                    <button
                                        class="p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg transition-all">
                                        <MoreHorizontal class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs font-bold text-slate-400 uppercase tracking-widest">
                <span>Showing 3 of 48 Applicants</span>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 rounded-md border border-slate-200 dark:border-slate-700 hover:bg-white transition-all">Prev</button>
                    <button
                        class="px-3 py-1 rounded-md border border-slate-200 dark:border-slate-700 hover:bg-white transition-all">Next</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>