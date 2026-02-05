<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import {
    LayoutDashboard,
    Users,
    BarChart3,
    Settings,
    Package,
    Building,
    LogOut,
    ChevronRight,
    UserPlus // CRITICAL: Added this import
} from 'lucide-vue-next'

const page = usePage()
const user = computed(() => page.props.auth.user)
const currentUrl = computed(() => page.url)

const navItems = computed(() => {
    const items = [
        { label: 'Main Dashboard', href: route('dashboard'), icon: LayoutDashboard },
    ]

    // HRM Department Logic
    if (user.value?.role === 'HRM') {
        items.push({ label: 'Employee Dashboard', href: route('hrm.employee.dashboard'), icon: Users });

        if (user.value?.position === 'manager') {
            items.push(
                { label: 'HR Analytics', href: route('hrm.manager.dashboard'), icon: BarChart3 },
                { label: 'Recruitment', href: route('hrm.applicants.index'), icon: UserPlus }
            );
        }
    }

    // SCM Department Logic
    if (user.value?.role === 'SCM') {
        items.push({ label: 'Inventory', href: route('scm.employee.dashboard'), icon: Package });
        if (user.value?.position === 'manager') {
            items.push({ label: 'SCM Analytics', href: route('scm.manager.dashboard'), icon: Building });
        }
    }

    items.push({ label: 'Profile Settings', href: route('profile.edit'), icon: Settings })

    return items
})

const isActive = (href) => {
    return currentUrl.value === href || currentUrl.value.startsWith(href + '/')
}
</script>

<template>
    <aside class="hidden md:flex md:w-72 md:flex-col md:fixed md:inset-y-0 z-50">
        <div
            class="flex flex-col flex-grow bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800 shadow-sm transition-colors duration-300">
            <div class="flex items-center h-20 flex-shrink-0 px-6 border-b border-gray-50 dark:border-gray-800">
                <div
                    class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg mr-3">
                    <span class="text-white font-bold text-lg tracking-tighter italic">M</span>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white leading-tight">Monti <span
                            class="text-blue-600">Textile</span></h2>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ERP System</span>
                </div>
            </div>

            <div class="flex-1 flex flex-col overflow-y-auto py-6">
                <nav class="flex-1 px-4 space-y-1.5">
                    <Link v-for="item in navItems" :key="item.label" :href="item.href" :class="[
                        isActive(item.href)
                            ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 ring-1 ring-blue-100 dark:ring-blue-900/30'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white'
                    ]"
                        class="group flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                        <div class="flex items-center">
                            <component :is="item.icon"
                                :class="[isActive(item.href) ? 'text-blue-600' : 'text-gray-400']"
                                class="mr-3 h-5 w-5 flex-shrink-0" />
                            {{ item.label }}
                        </div>
                        <ChevronRight v-if="isActive(item.href)" class="h-4 w-4" />
                    </Link>
                </nav>
            </div>

            <div
                class="flex-shrink-0 border-t border-gray-100 dark:border-gray-800 p-4 bg-gray-50/50 dark:bg-gray-900/50">
                <div class="flex items-center group p-2 rounded-2xl">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold shadow-md">
                            {{ user?.name?.charAt(0) }}
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate uppercase tracking-tight">{{
                            user?.name }}</p>
                        <div class="flex items-center text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase">
                            {{ user?.role }} • {{ user?.position }}
                        </div>
                    </div>
                    <Link :href="route('logout')" method="post" as="button"
                        class="ml-2 p-2 rounded-lg text-gray-400 hover:text-red-600 transition-all">
                        <LogOut class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </div>
    </aside>
</template>