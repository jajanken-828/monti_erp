<script setup>
import Sidebar from './Sidebar.vue'
import MobileSidebar from './MobileSidebar.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Desktop Sidebar -->
        <Sidebar />

        <!-- Mobile header -->
        <div class="md:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <MobileSidebar>
                            <template #mobile-nav>
                                <Link href="dashboard"
                                    class="group flex items-center px-3 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Main Dashboard
                                </Link>
                                <Link href="/profile"
                                    class="group flex items-center px-3 py-2 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Profile Settings
                                </Link>
                            </template>
                        </MobileSidebar>
                        <div class="ml-4">
                            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Monti Textile
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:pl-64">
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>