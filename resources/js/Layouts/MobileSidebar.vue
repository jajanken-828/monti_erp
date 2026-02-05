<script setup>
import { ref, computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import {
    Menu,
    X,
    Box,
    LogOut,
    User as UserIcon,
    ShieldCheck
} from 'lucide-vue-next'

const isOpen = ref(false)
const page = usePage()
const user = computed(() => page.props.auth.user)

const closeSidebar = () => {
    isOpen.value = false
}
</script>

<template>
    <div class="md:hidden">
        <button @click="isOpen = true"
            class="p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none">
            <Menu class="h-6 w-6" />
        </button>

        <Teleport to="body">
            <div v-if="isOpen" class="fixed inset-0 z-[60] flex md:hidden">

                <transition enter-active-class="transition-opacity ease-linear duration-300"
                    enter-from-class="opacity-0" enter-to-class="opacity-100"
                    leave-active-class="transition-opacity ease-linear duration-300" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeSidebar"></div>
                </transition>

                <transition enter-active-class="transition ease-in-out duration-300 transform"
                    enter-from-class="-translate-x-full" enter-to-class="translate-x-0"
                    leave-active-class="transition ease-in-out duration-300 transform" leave-from-class="translate-x-0"
                    leave-to-class="-translate-x-full">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-900 shadow-2xl">

                        <div class="absolute top-0 right-0 -mr-12 pt-4">
                            <button @click="closeSidebar"
                                class="flex items-center justify-center h-10 w-10 rounded-full bg-white/10 text-white hover:bg-white/20 focus:outline-none ring-2 ring-white/20 transition-all">
                                <X class="h-6 w-6" />
                            </button>
                        </div>

                        <div
                            class="flex-shrink-0 px-6 py-6 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-9 w-9 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-500/20 mr-3">
                                    <span class="text-white font-bold text-sm">MT</span>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">
                                    Monti <span class="text-blue-600">Textile</span>
                                </h2>
                            </div>

                            <div
                                class="flex items-center p-3 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 flex items-center justify-center text-blue-700 dark:text-blue-300 font-bold border border-white dark:border-gray-700 shadow-sm">
                                    {{ user?.name?.charAt(0) }}
                                </div>
                                <div class="ml-3 overflow-hidden">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ user?.name }}
                                    </p>
                                    <div
                                        class="flex items-center text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                        <ShieldCheck class="h-3 w-3 mr-1" />
                                        {{ user?.department }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 h-0 pt-4 pb-4 overflow-y-auto">
                            <nav class="px-3 space-y-1" @click="closeSidebar">
                                <slot name="mobile-nav" />
                            </nav>
                        </div>

                        <div
                            class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/30">
                            <Link :href="route('logout')" method="post" as="button"
                                class="flex w-full items-center justify-center px-4 py-3 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-bold text-sm transition-all active:scale-95 shadow-sm border border-red-100 dark:border-red-900/30">
                                <LogOut class="mr-2 h-5 w-5" />
                                Sign Out
                            </Link>

                            <div
                                class="mt-4 flex items-center justify-center space-x-2 text-[10px] text-gray-400 font-medium uppercase tracking-widest">
                                <Box class="h-3 w-3" />
                                <span>Monti ERP v1.0</span>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </Teleport>
    </div>
</template>