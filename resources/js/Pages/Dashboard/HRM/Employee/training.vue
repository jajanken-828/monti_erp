<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, computed } from 'vue'
import {
    BookOpen,
    PlayCircle,
    CheckCircle2,
    Award,
    Clock,
    Search,
    Video,
    FileText,
    ArrowRight,
    GraduationCap
} from 'lucide-vue-next'

const props = defineProps({
    courses: {
        type: Array,
        default: () => [
            { id: 1, title: 'Textile Safety Standards', category: 'Safety', progress: 100, status: 'Completed', deadline: 'Completed' },
            { id: 2, title: 'Advanced Weaver Operations', category: 'Technical', progress: 45, status: 'In Progress', deadline: 'Feb 20, 2026' },
            { id: 3, title: 'ERP System Basics', category: 'Operational', progress: 0, status: 'Not Started', deadline: 'Mar 01, 2026' },
        ]
    }
})

const getProgressColor = (progress) => {
    if (progress === 100) return 'bg-emerald-500'
    if (progress > 0) return 'bg-blue-500'
    return 'bg-slate-200'
}
</script>

<template>

    <Head title="Staff Training & Development" />

    <AuthenticatedLayout>
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Training <span class="text-blue-600">& Growth</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Enhance your skills and track your
                    certification progress.</p>
            </div>
            <div
                class="flex items-center gap-3 bg-white dark:bg-slate-800 p-2 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600">
                    <Award class="h-5 w-5" />
                </div>
                <div class="pr-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">
                        Certifications</p>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">12 Earned</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-blue-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-blue-500/20">
                    <div class="relative z-10">
                        <h2 class="text-xl font-black uppercase tracking-tight mb-2">Welcome back to Training</h2>
                        <p class="text-blue-100 text-sm mb-6 max-w-md">You've completed 45% of your "Advanced Weaver
                            Operations" course. Keep going to earn your technical badge!</p>
                        <button
                            class="px-6 py-3 bg-white text-blue-600 rounded-xl font-bold text-sm hover:bg-blue-50 transition-all flex items-center gap-2">
                            <PlayCircle class="h-4 w-4" /> Continue Learning
                        </button>
                    </div>
                    <GraduationCap class="absolute -bottom-4 -right-4 h-48 w-48 text-white/10 rotate-12" />
                </div>

                <div
                    class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <BookOpen class="h-5 w-5 text-blue-600" />
                            My Curriculum
                        </h3>
                        <div class="relative">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <input type="text" placeholder="Search courses..."
                                class="pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-xs focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>

                    <div class="divide-y divide-slate-50 dark:divide-slate-700">
                        <div v-for="course in courses" :key="course.id"
                            class="p-6 hover:bg-slate-50/50 transition-all group">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        :class="[course.progress === 100 ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600', 'h-12 w-12 rounded-2xl flex items-center justify-center shrink-0']">
                                        <Video v-if="course.progress < 100" class="h-6 w-6" />
                                        <CheckCircle2 v-else class="h-6 w-6" />
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                            {{ course.title }}</h4>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">
                                            {{ course.category }} • Deadline: {{ course.deadline }}</p>
                                    </div>
                                </div>
                                <div class="text-right min-w-[120px]">
                                    <p class="text-xs font-black text-slate-900 dark:text-white mb-2">{{ course.progress
                                        }}%</p>
                                    <div
                                        class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                        <div :class="[getProgressColor(course.progress), 'h-full transition-all duration-700']"
                                            :style="{ width: course.progress + '%' }"></div>
                                    </div>
                                </div>
                                <button class="p-2 text-slate-300 hover:text-blue-600 rounded-lg">
                                    <ArrowRight class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm">
                    <h3
                        class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                        <Clock class="h-4 w-4 text-blue-600" /> Live Sessions
                    </h3>
                    <div class="space-y-6">
                        <div class="flex gap-4 group cursor-pointer">
                            <div
                                class="flex flex-col items-center justify-center h-12 w-12 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 shrink-0">
                                <span class="text-[10px] font-black text-slate-400 uppercase leading-none">Feb</span>
                                <span class="text-sm font-black text-slate-900 dark:text-white">12</span>
                            </div>
                            <div>
                                <h4
                                    class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                    Workshop: Loom Maintenance</h4>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">10:00 AM - 12:00 PM • Training
                                    Room B</p>
                            </div>
                        </div>
                        <div class="flex gap-4 group cursor-pointer">
                            <div
                                class="flex flex-col items-center justify-center h-12 w-12 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 shrink-0">
                                <span class="text-[10px] font-black text-slate-400 uppercase leading-none">Feb</span>
                                <span class="text-sm font-black text-slate-900 dark:text-white">15</span>
                            </div>
                            <div>
                                <h4
                                    class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                    HR Policy Review (Mandatory)</h4>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">02:00 PM - 03:00 PM • Virtual
                                    Session</p>
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full mt-8 py-3 bg-slate-50 dark:bg-slate-900 hover:bg-blue-50 text-slate-600 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest rounded-xl transition-all">
                        Sync to My Calendar
                    </button>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-6 text-slate-400">Resources</h3>
                    <div class="space-y-4">
                        <a href="#"
                            class="flex items-center justify-between p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all border border-white/10 group">
                            <div class="flex items-center gap-3">
                                <FileText class="h-4 w-4 text-blue-400" />
                                <span class="text-xs font-bold">Standard Ops Manual</span>
                            </div>
                            <ArrowRight class="h-3 w-3 opacity-0 group-hover:opacity-100 transition-all" />
                        </a>
                        <a href="#"
                            class="flex items-center justify-between p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all border border-white/10 group">
                            <div class="flex items-center gap-3">
                                <Video class="h-4 w-4 text-purple-400" />
                                <span class="text-xs font-bold">Machine Safety Demo</span>
                            </div>
                            <ArrowRight class="h-3 w-3 opacity-0 group-hover:opacity-100 transition-all" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>