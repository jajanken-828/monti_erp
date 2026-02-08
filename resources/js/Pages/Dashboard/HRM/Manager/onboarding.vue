<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, computed } from 'vue'
import draggable from 'vuedraggable'
import {
    Search,
    UserPlus,
    Filter,
    MoreHorizontal,
    Mail,
    FileText,
    CheckCircle2,
    Clock,
    XCircle,
    ArrowUpRight,
    Users,
    Briefcase,
    Calendar,
    GripVertical
} from 'lucide-vue-next'

const props = defineProps({
    applicants: {
        type: Array,
        default: () => [
            { id: 1, name: 'John Doe', email: 'john@example.com', position: 'Weaver', status: 'FOR INTERVIEW', date: '2024-02-01' },
            { id: 2, name: 'Jane Smith', email: 'jane@example.com', position: 'Quality Control', status: 'FOR INTERVIEW', date: '2024-02-03' },
            { id: 3, name: 'Mike Ross', email: 'mike@example.com', position: 'Floor Manager', status: 'FINAL INTERVIEW', date: '2024-01-28' },
            { id: 4, name: 'Harvey Specter', email: 'harvey@example.com', position: 'Legal Lead', status: 'ONBOARDING', date: '2024-01-25' },
        ]
    }
})

// Grouping logic for the Draggable Columns
const pipeline = ref({
    'FOR INTERVIEW': props.applicants.filter(a => a.status === 'FOR INTERVIEW'),
    'FINAL INTERVIEW': props.applicants.filter(a => a.status === 'FINAL INTERVIEW'),
    'ONBOARDING': props.applicants.filter(a => a.status === 'ONBOARDING')
})

const onDragEnd = (evt) => {
    // Logic to handle status update in DB via Inertia would go here
    console.log('Moved:', evt.item)
}

// Summary cards logic
const stats = computed(() => [
    { label: 'Total Applicants', value: props.applicants.length, icon: Users, color: 'text-blue-600', bg: 'bg-blue-50' },
    { label: 'Pending Review', value: props.applicants.filter(a => a.status === 'Pending').length, icon: Clock, color: 'text-amber-600', bg: 'bg-amber-50' },
    { label: 'For Interview', value: pipeline.value['FOR INTERVIEW'].length, icon: Calendar, color: 'text-indigo-600', bg: 'bg-indigo-50' },
    { label: 'Onboarding', value: pipeline.value['ONBOARDING'].length, icon: CheckCircle2, color: 'text-emerald-600', bg: 'bg-emerald-50' },
])
</script>

<template>

    <Head title="Recruitment Pipeline" />

    <AuthenticatedLayout>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Recruitment <span class="text-blue-600">Pipeline</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Drag and drop applicants to update
                    their hiring stage.</p>
            </div>
            <button
                class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                <UserPlus class="h-4 w-4" />
                Add New Applicant
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div v-for="stat in stats" :key="stat.label"
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div :class="[stat.bg, 'p-2.5 rounded-xl']">
                        <component :is="stat.icon" :class="[stat.color, 'h-5 w-5']" />
                    </div>
                    <ArrowUpRight class="h-4 w-4 text-slate-300" />
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-500">{{ stat.label }}</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ stat.value }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div v-for="(list, stage) in pipeline" :key="stage" class="flex flex-col min-w-[300px]">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h2
                        class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        {{ stage }}
                    </h2>
                    <span
                        class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-bold">
                        {{ list.length }}
                    </span>
                </div>

                <draggable v-model="pipeline[stage]" group="applicants" @end="onDragEnd" item-key="id"
                    class="space-y-4 min-h-[500px] p-3 bg-slate-50/50 dark:bg-slate-900/30 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-700/50"
                    ghost-class="opacity-50">
                    <template #item="{ element }">
                        <div
                            class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm cursor-grab active:cursor-grabbing group hover:border-blue-400 transition-colors">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 font-bold text-sm mr-3">
                                        {{ element.name.charAt(0) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ element.name
                                            }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium">{{ element.email }}</span>
                                    </div>
                                </div>
                                <GripVertical class="h-4 w-4 text-slate-300 group-hover:text-slate-400" />
                            </div>

                            <div class="flex items-center gap-2 mb-4">
                                <Briefcase class="h-3.5 w-3.5 text-slate-400" />
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">{{
                                    element.position }}</span>
                            </div>

                            <div
                                class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-700">
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{
                                    element.date }}</span>
                                <div class="flex items-center gap-1">
                                    <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-md transition-all">
                                        <FileText class="h-3.5 w-3.5" />
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-rose-500 rounded-md transition-all">
                                        <XCircle class="h-3.5 w-3.5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.ghost-class {
    background: #eff6ff !important;
    border: 2px solid #3b82f6 !important;
    opacity: 0.8;
}
</style>