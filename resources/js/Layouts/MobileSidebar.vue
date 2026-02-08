<script setup>
import { ref, computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import {
    Menu,
    X,
    LogOut,
    ShieldCheck,
    LayoutDashboard,
    BarChart3,
    Package,
    UserPlus,
    ClipboardList,
    ChartNoAxesCombined,
    HandCoins,
    FileUser,
    DoorOpen,
    BicepsFlexed,
    Truck
} from 'lucide-vue-next'

const isOpen = ref(false)
const page = usePage()
const user = computed(() => page.props.auth.user)

// Unified navigation logic to match the Desktop Sidebar for all 4 roles
const navItems = computed(() => {
    const items = [
        { label: 'Main Dashboard', href: route('dashboard'), icon: LayoutDashboard },
    ]

    const userRole = user.value?.role?.toUpperCase();
    const userPosition = user.value?.position?.toLowerCase();

    // HRM Department Mobile Logic
    if (userRole === 'HRM') {
        if (userPosition === 'manager') {
            items.push(
                { label: 'Onboarding', href: route('hrm.manager.onboarding'), icon: BarChart3 },
                { label: 'Recruitment', href: route('hrm.applicants.index'), icon: UserPlus },
                { label: 'Payroll', href: route('hrm.manager.payroll'), icon: HandCoins },
                { label: 'Analytics', href: route('hrm.manager.analytics'), icon: ChartNoAxesCombined }
            );
        } else if (userPosition === 'staff') {
            items.push(
                // { label: 'My HR Portal', href: route('hrm.employee.dashboard'), icon: ClipboardList }
                { label: 'Recruitment', href: route('hrm.applicants.index'), icon: UserPlus },
                { label: 'Interview', href: route('hrm.employee.interview'), icon: ClipboardList },
                { label: 'Training & Development', href: route('hrm.employee.training'), icon: BicepsFlexed },
                { label: 'Attendance', href: route('hrm.employee.attendance'), icon: FileUser },
                { label: 'Leave Management', href: route('hrm.employee.leave'), icon: DoorOpen }
            );
        }
    }

    // SCM Department Mobile Logic
    if (userRole === 'SCM') {
        if (userPosition === 'manager') {
            items.push({
                label: 'Inventory Dashboard',
                href: route('scm.manager.dashboard'),
                icon: Package
            });
        } else if (userPosition === 'staff') {
            items.push(
                { label: 'Logistics Tasks', href: route('scm.staff.dashboard'), icon: Truck }
            );
        }
    }

    return items
})

const closeSidebar = () => {
    isOpen.value = false
}
</script>

<template>
    <div class="md:hidden">
        <button @click="isOpen = true"
            class="p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
            <Menu class="h-6 w-6" />
        </button>

        <Teleport to="body">
            <div v-if="isOpen" class="fixed inset-0 z-[60] flex md:hidden">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeSidebar"></div>

                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-900 shadow-2xl">
                    <div class="absolute top-0 right-0 -mr-12 pt-4">
                        <button @click="closeSidebar"
                            class="h-10 w-10 rounded-full bg-white/10 text-white flex items-center justify-center">
                            <X class="h-6 w-6" />
                        </button>
                    </div>

                    <div class="flex-shrink-0 px-6 py-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center mb-6">
                            <div class="h-10 w-10 flex-shrink-0 mr-3">
                                <img src="/images/applogo.png" alt="Monti Textile Logo"
                                    class="h-full w-full object-contain" />
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Monti <span
                                    class="text-blue-600">Textile</span></h2>
                        </div>

                        <div
                            class="flex items-center p-3 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                            <div
                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                                {{ user?.name?.charAt(0) }}
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate uppercase">{{
                                    user?.name }}</p>
                                <div
                                    class="flex items-center text-[10px] font-semibold text-blue-600 uppercase tracking-wider">
                                    <ShieldCheck class="h-3 w-3 mr-1" />
                                    {{ user?.role }} • {{ user?.position }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 h-0 pt-4 pb-4 overflow-y-auto">
                        <nav class="px-3 space-y-1">
                            <Link v-for="item in navItems" :key="item.label" :href="item.href" @click="closeSidebar"
                                class="group flex items-center px-3 py-3 text-base font-bold rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <component :is="item.icon" class="mr-3 h-5 w-5 text-gray-400" />
                                {{ item.label }}
                            </Link>
                        </nav>
                    </div>

                    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/30">
                        <Link :href="route('logout')" method="post" as="button"
                            class="flex w-full items-center justify-center px-4 py-3 rounded-xl bg-red-50 text-red-600 font-bold text-sm">
                            <LogOut class="mr-2 h-5 w-5" />
                            Sign Out
                        </Link>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>