<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';
import {
    Search,
    UserPlus,
    Filter,
    MoreHorizontal,
    Mail,
    FileText,
    User,
    Calendar,
    Home,
    Phone,
    Briefcase,
    Upload,
    ShieldCheck,
    X,
    Save,
    FileCheck,
    Trash2,
    Info,
    Clock,
    Eye,
    ExternalLink,
    Loader2
} from 'lucide-vue-next';

const props = defineProps({
    applicants: {
        type: Array,
        default: () => []
    }
});

const searchQuery = ref('');
const isModalOpen = ref(false);
const isScheduleModalOpen = ref(false);
const isViewModalOpen = ref(false);
const selectedApplicant = ref(null);
const viewingApplicant = ref(null);
const isLoading = ref(true);
const localApplicants = ref([]); // Local copy of applicants

// Initialize local applicants when props change
watch(() => props.applicants, (newApplicants) => {
    localApplicants.value = [...newApplicants];
}, { immediate: true });

// Simulate Lazy Loading on mount
onMounted(() => {
    setTimeout(() => {
        isLoading.value = false;
    }, 500);
});

// Main Applicant Registration Form using Inertia useForm
const form = useForm({
    first_name: '',
    middle_name: '',
    last_name: '',
    street_address: '',
    street_address_line2: '',
    city: '',
    state_province: '',
    postal_zip_code: '',
    email: '',
    phone_number: '',
    position_applied: '',
    expected_salary: '',
    notice_period: 'immediate',
    textile_experience: 'no',
    sss_file: null,
    philhealth_file: null,
    pagibig_file: null
});

// Interview Scheduling Form
const scheduleForm = useForm({
    scheduled_at: ''
});

// Computed logic for Search
const filteredApplicants = computed(() => {
    return localApplicants.value.filter(person =>
        person.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        person.position.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        person.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Logic for Notice Period constraint
const minInterviewDate = computed(() => {
    if (!selectedApplicant.value) return '';
    const date = new Date();
    if (selectedApplicant.value.notice_period === '30_days') {
        date.setDate(date.getDate() + 30);
    } else if (selectedApplicant.value.notice_period === '15_days') {
        date.setDate(date.getDate() + 15);
    }
    return date.toISOString().slice(0, 16);
});

const openScheduleModal = (applicant) => {
    selectedApplicant.value = applicant;
    isScheduleModalOpen.value = true;
};

const closeScheduleModal = () => {
    isScheduleModalOpen.value = false;
    scheduleForm.reset();
};

const openViewModal = (applicant) => {
    viewingApplicant.value = applicant;
    isViewModalOpen.value = true;
};

const closeViewModal = () => {
    isViewModalOpen.value = false;
    viewingApplicant.value = null;
};

const handleFileUpload = (event, type) => {
    const file = event.target.files[0];
    if (file) form[type + '_file'] = file;
};

const removeFile = (type) => {
    form[type + '_file'] = null;
};

const getStatusClass = (status) => {
    switch (status) {
        case 'Interview': return 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
        case 'Hired': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
        case 'Rejected': return 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400';
        default: return 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
    }
};

const submitForm = () => {
    form.post(route('hrm.applicants.store'), {
        forceFormData: true,
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            isModalOpen.value = false;
            form.reset();

            // Get the new applicant from the response
            const newApplicant = page.props.applicant || page.props.applicants?.slice(-1)[0];

            if (newApplicant) {
                // Add the new applicant to the local list
                localApplicants.value.push(newApplicant);

                // Show success message (optional)
                console.log('Applicant added successfully');
            }

            // Force refresh the applicants list from server
            router.reload({
                only: ['applicants'],
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    // Update local applicants after reload
                    localApplicants.value = [...page.props.applicants];
                }
            });
        },
        onError: (errors) => {
            console.error('Form submission errors:', errors);
        }
    });
};

const submitSchedule = () => {
    if (!selectedApplicant.value) return;

    scheduleForm.post(route('hrm.applicants.schedule', selectedApplicant.value.id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            closeScheduleModal();

            // Find and update the applicant in the local list
            const index = localApplicants.value.findIndex(app => app.id === selectedApplicant.value.id);
            if (index !== -1) {
                // Update the applicant with new data
                const updatedApplicant = page.props.applicant || selectedApplicant.value;
                localApplicants.value[index] = { ...localApplicants.value[index], ...updatedApplicant };

                // Force refresh to get updated status
                router.reload({
                    only: ['applicants'],
                    preserveScroll: true,
                    preserveState: true,
                    onFinish: () => {
                        localApplicants.value = [...page.props.applicants];
                    }
                });
            }
        },
        onError: (errors) => {
            console.error('Schedule submission errors:', errors);
        }
    });
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
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Manage and track new applications for
                    Monti Textile.</p>
            </div>
            <button @click="isModalOpen = true"
                class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                <UserPlus class="h-4 w-4" /> Add New Applicant
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative md:col-span-2">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                <input v-model="searchQuery" type="text" placeholder="Search by name, email or position..."
                    class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-blue-600 text-sm" />
            </div>
            <button
                class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all">
                <Filter class="h-4 w-4" /> Advanced Filters
            </button>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden min-h-[400px] relative">

            <div v-if="isLoading"
                class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                <Loader2 class="h-10 w-10 text-blue-600 animate-spin mb-2" />
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Loading Candidates...</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Applicant</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Position</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Notice Period</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <tr v-if="filteredApplicants.length === 0 && !isLoading">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No applicants
                                    found</p>
                            </td>
                        </tr>

                        <tr v-for="person in filteredApplicants" :key="person.id"
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
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-300">{{
                                person.position }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500 font-bold uppercase text-[10px] tracking-tight">
                                {{ person.notice_period.replace('_', ' ') }}
                            </td>
                            <td class="px-6 py-4">
                                <span :class="getStatusClass(person.status)"
                                    class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                    {{ person.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button @click="openViewModal(person)"
                                        class="p-2 text-slate-400 hover:text-blue-600 rounded-lg transition-all"
                                        title="View Details">
                                        <Eye class="h-5 w-5" />
                                    </button>
                                    <button @click="openScheduleModal(person)"
                                        class="p-2 text-slate-400 hover:text-emerald-600 rounded-lg transition-all"
                                        title="Set Interview Schedule">
                                        <Calendar class="h-5 w-5" />
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
        </div>

        <div v-if="isViewModalOpen" class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeViewModal"></div>
            <div
                class="relative w-full max-w-4xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div
                    class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between sticky top-0 bg-white dark:bg-slate-900 z-20">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Applicant
                            <span class="text-blue-600">Details</span>
                        </h2>
                        <p class="text-xs text-slate-500 font-medium tracking-tight">Application ID: #{{
                            viewingApplicant?.id }}</p>
                    </div>
                    <button @click="closeViewModal"
                        class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                        <X class="h-5 w-5 text-slate-400" />
                    </button>
                </div>
                <div class="overflow-y-auto p-8 custom-scrollbar space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">Personal
                                    Information</h4>
                                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-3xl space-y-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Full
                                            Name</p>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{
                                            viewingApplicant?.name }}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                Email</p>
                                            <p class="text-xs font-medium text-slate-900 dark:text-white break-words">{{
                                                viewingApplicant?.email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                Phone</p>
                                            <p class="text-xs font-medium text-slate-900 dark:text-white">{{
                                                viewingApplicant?.phone_number || 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                            Address</p>
                                        <p class="text-xs font-medium text-slate-900 dark:text-white">
                                            {{ viewingApplicant?.street_address }}, {{ viewingApplicant?.city }}, {{
                                                viewingApplicant?.state_province }} {{ viewingApplicant?.postal_zip_code }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-3">
                                    Application Status</h4>
                                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-3xl space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                Position</p>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{
                                                viewingApplicant?.position }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                Notice Period</p>
                                            <p
                                                class="text-sm font-bold text-amber-600 uppercase text-[10px] tracking-tight">
                                                {{ viewingApplicant?.notice_period.replace('_', ' ') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                            Current Status</p>
                                        <span :class="getStatusClass(viewingApplicant?.status)"
                                            class="inline-block mt-1 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                            {{ viewingApplicant?.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Submitted
                            Government IDs</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div v-for="type in ['sss', 'philhealth', 'pagibig']" :key="type" class="group">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">{{
                                    type }} Document</p>
                                <div
                                    class="relative bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-4 overflow-hidden aspect-[4/3] flex flex-col items-center justify-center transition-all hover:shadow-xl hover:border-blue-500/50">
                                    <template v-if="viewingApplicant?.[type + '_file_url']">
                                        <img :src="viewingApplicant[type + '_file_url']"
                                            class="absolute inset-0 w-full h-full object-cover opacity-20"
                                            alt="ID preview">
                                        <div class="z-10 text-center">
                                            <FileCheck class="h-10 w-10 text-emerald-500 mb-2 mx-auto" />
                                            <p class="text-[10px] font-bold text-slate-900 dark:text-white uppercase">ID
                                                Uploaded</p>
                                            <a :href="viewingApplicant[type + '_file_url']" target="_blank"
                                                class="mt-3 flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 rounded-xl text-[10px] font-black uppercase tracking-tighter shadow-sm hover:bg-blue-600 hover:text-white transition-all">
                                                <ExternalLink class="h-3 w-3" /> View Full File
                                            </a>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Info class="h-10 w-10 text-slate-200 mb-2" />
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">No File Provided</p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="p-8 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-end gap-3">
                    <button @click="closeViewModal"
                        class="px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-xl shadow-slate-900/20 active:scale-95 transition-all">Close
                        Details</button>
                </div>
            </div>
        </div>

        <div v-if="isScheduleModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeScheduleModal"></div>
            <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Set <span
                                class="text-blue-600">Interview</span></h2>
                        <p class="text-sm text-slate-500 font-medium">Candidate: {{ selectedApplicant?.name }}</p>
                    </div>
                    <button @click="closeScheduleModal" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                        <X class="h-5 w-5 text-slate-400" />
                    </button>
                </div>
                <form @submit.prevent="submitSchedule" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Appointment Date
                            &
                            Time</label>
                        <div class="relative">
                            <Clock class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                            <input type="datetime-local" v-model="scheduleForm.scheduled_at" :min="minInterviewDate"
                                required
                                class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-blue-600" />
                        </div>
                        <div v-if="selectedApplicant?.notice_period !== 'immediate'"
                            class="flex items-center gap-2 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl mt-2">
                            <Info class="h-4 w-4 text-amber-600 shrink-0" />
                            <p class="text-[10px] text-amber-700 dark:text-amber-400 font-bold uppercase leading-tight">
                                Notice Period Constraint: Selection restricted until after {{ new
                                    Date(minInterviewDate).toLocaleDateString() }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="closeScheduleModal"
                            class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all">Cancel</button>
                        <button type="submit" :disabled="scheduleForm.processing"
                            class="flex-1 bg-blue-600 text-white py-3.5 rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/25 active:scale-95 disabled:opacity-50">
                            Confirm Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isModalOpen = false"></div>
            <div
                class="relative w-full max-w-4xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div
                    class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between sticky top-0 bg-white dark:bg-slate-900 z-20">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">New <span
                                class="text-blue-600">Applicant</span></h2>
                        <p class="text-xs text-slate-500 font-medium tracking-tight">Registration for Monti Textile
                            Recruitment.
                        </p>
                    </div>
                    <button @click="isModalOpen = false"
                        class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                        <X class="h-5 w-5 text-slate-400" />
                    </button>
                </div>
                <div class="overflow-y-auto p-8 custom-scrollbar space-y-8">
                    <form @submit.prevent="submitForm" class="space-y-8">
                        <div
                            class="bg-blue-50/50 dark:bg-blue-900/10 p-6 rounded-[2rem] border border-blue-100 dark:border-blue-900/20 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/30">
                                    <User class="text-white h-5 w-5" />
                                </div>
                                <h4 class="text-lg font-black text-slate-800 dark:text-white">Full Name</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">First Name *</label>
                                    <input v-model="form.first_name" type="text" required
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Middle Name</label>
                                    <input v-model="form.middle_name" type="text"
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Last Name *</label>
                                    <input v-model="form.last_name" type="text" required
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-slate-50/50 dark:bg-slate-800/50 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-blue-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/20">
                                    <Home class="text-white h-5 w-5" />
                                </div>
                                <h4 class="text-lg font-black text-slate-800 dark:text-white">Current Address</h4>
                            </div>
                            <div class="space-y-5">
                                <input v-model="form.street_address" type="text" required placeholder="Street Address"
                                    class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm">
                                <input v-model="form.street_address_line2" type="text"
                                    placeholder="Apartment, Suite, Unit, etc."
                                    class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <input v-model="form.city" type="text" required placeholder="City"
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm">
                                    <input v-model="form.state_province" type="text" required
                                        placeholder="State / Province"
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm">
                                    <input v-model="form.postal_zip_code" type="text" required
                                        placeholder="Postal / Zip Code"
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm">
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-blue-50/30 dark:bg-blue-900/5 p-6 rounded-[2rem] border border-blue-100 dark:border-blue-900/10 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/20">
                                    <Briefcase class="text-white h-5 w-5" />
                                </div>
                                <h4 class="text-lg font-black text-slate-800 dark:text-white">Professional Info</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Email Address *</label>
                                    <input v-model="form.email" type="email" required
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Phone Number *</label>
                                    <input v-model="form.phone_number" type="text" required
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Position Applied *</label>
                                    <input v-model="form.position_applied" type="text" required
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-500 ml-1">Notice Period *</label>
                                    <select v-model="form.notice_period"
                                        class="w-full px-5 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border-none ring-1 ring-slate-200 dark:ring-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                                        <option value="immediate">Immediate</option>
                                        <option value="15_days">15 Days</option>
                                        <option value="30_days">30 Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-emerald-50/20 dark:bg-emerald-900/5 p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-900/10 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 bg-emerald-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-emerald-500/30">
                                    <FileCheck class="text-white h-5 w-5" />
                                </div>
                                <h4 class="text-lg font-black text-slate-800 dark:text-white">Government IDs</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div v-for="type in ['sss', 'philhealth', 'pagibig']" :key="type" class="space-y-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{
                                        type }}
                                        ID</p>
                                    <div :class="form[type + '_file'] ? 'border-emerald-500 bg-emerald-50/50' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800'"
                                        class="relative h-32 rounded-3xl border-2 border-dashed flex flex-col items-center justify-center p-4 transition-all group">
                                        <template v-if="!form[type + '_file']">
                                            <Upload
                                                class="h-5 w-5 text-slate-300 group-hover:text-blue-500 transition-colors mb-2" />
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                                Click to upload</p>
                                            <input type="file" @change="(e) => handleFileUpload(e, type)"
                                                class="absolute inset-0 opacity-0 cursor-pointer"
                                                accept=".pdf,.jpg,.png">
                                        </template>
                                        <template v-else>
                                            <div class="flex flex-col items-center text-center">
                                                <FileCheck class="h-6 w-6 text-emerald-600 mb-1" />
                                                <p class="text-[10px] font-black text-emerald-800 truncate w-24">{{
                                                    form[type + '_file'].name }}</p>
                                                <button @click="removeFile(type)" type="button"
                                                    class="mt-2 p-1 bg-rose-100 text-rose-600 rounded-lg">
                                                    <Trash2 class="h-3 w-3" />
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-slate-100 dark:border-slate-800 space-y-4 sm:space-y-0 sticky bottom-0 bg-white dark:bg-slate-900 z-10 py-4">
                            <div
                                class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <ShieldCheck class="h-4 w-4 text-emerald-500 mr-2" /> Verified & Encrypted
                            </div>
                            <div class="flex gap-3 w-full sm:w-auto">
                                <button type="button" @click="isModalOpen = false"
                                    class="flex-1 sm:flex-none px-8 py-3.5 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all">Cancel</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/25 active:scale-95">
                                    <Save class="h-4 w-4" /> Save Applicant
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155;
}
</style>