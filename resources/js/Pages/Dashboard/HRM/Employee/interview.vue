<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'
import {
    Calendar,
    Clock,
    User,
    Video,
    MapPin,
    Star,
    ChevronRight,
    FileText,
    CheckCircle2,
    XCircle,
    ClipboardList,
    ExternalLink
} from 'lucide-vue-next'

const props = defineProps({
    todays_interviews: {
        type: Array,
        default: () => [
            { id: 1, name: 'Alexander Wright', time: '10:00 AM', type: 'Virtual', position: 'Senior Weaver', avatar: 'AW' },
            { id: 2, name: 'Sarah Jenkins', time: '02:30 PM', type: 'In-Person', position: 'QC Inspector', avatar: 'SJ' },
        ]
    },
    past_interviews: {
        type: Array,
        default: () => [
            { id: 101, name: 'Michael Chen', date: 'Feb 05', position: 'Shift Lead', score: 4.5, status: 'Recommended' },
            { id: 102, name: 'Jessica Lee', date: 'Feb 04', position: 'Production Assistant', score: 3.2, status: 'On Hold' },
        ]
    }
})

const getScoreColor = (score) => {
    if (score >= 4) return 'text-emerald-500'
    if (score >= 3) return 'text-amber-500'
    return 'text-rose-500'
}
</script>

<template>

    <Head title="Interview Management" />

    <AuthenticatedLayout>
        <div class="mb-8">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                Interview <span class="text-blue-600">Management</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Manage your daily schedule and candidate
                evaluations.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h2
                            class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <Clock class="h-4 w-4 text-blue-600" /> Today's Agenda
                        </h2>
                        <span
                            class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 text-[10px] font-black rounded-lg">
                            {{ todays_interviews.length }} SESSIONS
                        </span>
                    </div>

                    <div class="space-y-6">
                        <div v-for="interview in todays_interviews" :key="interview.id"
                            class="relative pl-6 border-l-2 border-slate-100 dark:border-slate-700 group hover:border-blue-500 transition-colors">
                            <div
                                class="absolute -left-[5px] top-0 h-2 w-2 rounded-full bg-slate-300 group-hover:bg-blue-500">
                            </div>

                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-black text-blue-600 uppercase">{{ interview.time }}</span>
                                <span v-if="interview.type === 'Virtual'"
                                    class="flex items-center gap-1 text-[10px] font-bold text-slate-400 uppercase">
                                    <Video class="h-3 w-3" /> Remote
                                </span>
                                <span v-else
                                    class="flex items-center gap-1 text-[10px] font-bold text-slate-400 uppercase">
                                    <MapPin class="h-3 w-3" /> Office
                                </span>
                            </div>

                            <div
                                class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-transparent group-hover:border-blue-100 transition-all">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                        {{ interview.avatar }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">{{ interview.name
                                            }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ interview.position }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button
                                        class="flex-1 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[10px] font-bold uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all">
                                        View CV
                                    </button>
                                    <button
                                        class="flex-1 py-2 bg-blue-600 text-white rounded-xl text-[10px] font-bold uppercase tracking-wider shadow-lg shadow-blue-500/20">
                                        Score
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2rem] p-8 text-white">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-white/10 rounded-2xl">
                            <ClipboardList class="h-6 w-6 text-blue-400" />
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-widest">Interview Guide</h3>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed mb-6">
                        Remember to follow the structured scoring system for technical skills to ensure fair evaluation
                        across all weaving staff applicants.
                    </p>
                    <button
                        class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/10 transition-all">
                        Open Question Bank
                    </button>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600">
                                <CheckCircle2 class="h-5 w-5" />
                            </div>
                            Recent Evaluations
                        </h2>
                        <button
                            class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-blue-600 transition-colors">Archive</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                                    <th
                                        class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                        Candidate</th>
                                    <th
                                        class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                        Date</th>
                                    <th
                                        class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                        Rating</th>
                                    <th
                                        class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                        Decision</th>
                                    <th
                                        class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <tr v-for="past in past_interviews" :key="past.id"
                                    class="group hover:bg-slate-50/50 transition-all">
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ past.name
                                                }}</span>
                                            <span
                                                class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{
                                                past.position }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ past.date
                                            }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-1">
                                            <Star class="h-3 w-3 fill-current" :class="getScoreColor(past.score)" />
                                            <span class="text-sm font-black text-slate-900 dark:text-white">{{
                                                past.score }}</span>
                                            <span class="text-[10px] text-slate-400 font-bold">/ 5</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span :class="[
                                            past.status === 'Recommended' ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50',
                                            'px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider'
                                        ]">
                                            {{ past.status }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <button
                                            class="p-2 text-slate-300 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                            <FileText class="h-4 w-4" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="mt-6 p-6 bg-blue-50 dark:bg-blue-900/10 rounded-[2rem] border border-blue-100 dark:border-blue-800 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-12 w-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                            <Calendar class="h-6 w-6" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Planning a new session?</p>
                            <p class="text-xs text-slate-500 font-medium">Use the recruitment portal to invite new
                                applicants.</p>
                        </div>
                    </div>
                    <button
                        class="flex items-center gap-2 text-xs font-black text-blue-600 uppercase tracking-widest hover:underline">
                        Invite
                        <ChevronRight class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>