<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="Welcome to Monti Textile Manufacturing" />
    <div
        class="bg-gradient-to-br from-blue-50 to-gray-100 text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-200">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px] opacity-20"
            src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop"
            alt="Textile pattern background" />
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#1E40AF] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold text-[#1E40AF] dark:text-blue-400">
                                Monti Textile
                            </h1>
                            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                                Manufacturing Excellence Since 1985
                            </p>
                        </div>
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md bg-[#1E40AF] px-4 py-2 text-white ring-1 ring-transparent transition hover:bg-[#1E3A8A] focus:outline-none focus-visible:ring-[#1E40AF] dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus-visible:ring-white">
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-4 py-2 text-[#1E40AF] ring-1 ring-transparent transition hover:text-[#1E3A8A] focus:outline-none focus-visible:ring-[#1E40AF] dark:text-blue-400 dark:hover:text-blue-300 dark:focus-visible:ring-white">
                                Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="ml-3 rounded-md bg-[#1E40AF] px-4 py-2 text-white ring-1 ring-transparent transition hover:bg-[#1E3A8A] focus:outline-none focus-visible:ring-[#1E40AF] dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus-visible:ring-white">
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-200 transition duration-300 hover:shadow-xl hover:ring-blue-200 focus:outline-none focus-visible:ring-[#1E40AF] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:ring-blue-500">
                            <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch">
                                <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=2058&auto=format&fit=crop"
                                    alt="Monti Textile Manufacturing Facility"
                                    class="aspect-video h-full w-full flex-1 rounded-lg object-cover object-center shadow-md"
                                    @error="handleImageError" />
                            </div>

                            <div class="relative flex items-center gap-6 lg:items-end">
                                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                    <div
                                        class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#1E40AF]/10 sm:size-16">
                                        <svg class="size-5 sm:size-6 text-[#1E40AF]" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                        </svg>
                                    </div>

                                    <div class="pt-3 sm:pt-5 lg:pt-0">
                                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            About Monti Textile
                                        </h2>

                                        <p class="mt-4 text-sm/relaxed text-gray-600 dark:text-gray-300">
                                            Since 1985, Monti Textile has been a leader in high-quality fabric
                                            manufacturing.
                                            We specialize in sustainable textile production, innovative fabric
                                            technologies,
                                            and delivering exceptional products to clients worldwide.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-200 transition duration-300 hover:shadow-xl hover:ring-blue-200 focus:outline-none focus-visible:ring-[#1E40AF] lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:ring-blue-500">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#1E40AF]/10 sm:size-16">
                                <svg class="size-5 sm:size-6 text-[#1E40AF]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    HRM Portal
                                </h2>

                                <p class="mt-4 text-sm/relaxed text-gray-600 dark:text-gray-300">
                                    Access the Human Resource Management portal for employee management,
                                    payroll processing, attendance tracking, and workforce analytics.
                                </p>
                            </div>

                            <svg class="size-6 shrink-0 self-center stroke-[#1E40AF]" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="#"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-200 transition duration-300 hover:shadow-xl hover:ring-blue-200 focus:outline-none focus-visible:ring-[#1E40AF] lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:ring-blue-500">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#1E40AF]/10 sm:size-16">
                                <svg class="size-5 sm:size-6 text-[#1E40AF]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    SCM Portal
                                </h2>

                                <p class="mt-4 text-sm/relaxed text-gray-600 dark:text-gray-300">
                                    Manage supply chain operations including raw material procurement,
                                    inventory management, production planning, and logistics coordination.
                                </p>
                            </div>

                            <svg class="size-6 shrink-0 self-center stroke-[#1E40AF]" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-200 lg:pb-10 dark:bg-gray-800 dark:ring-gray-700">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#1E40AF]/10 sm:size-16">
                                <svg class="size-5 sm:size-6 text-[#1E40AF]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Secure & Reliable
                                </h2>

                                <p class="mt-4 text-sm/relaxed text-gray-600 dark:text-gray-300">
                                    Our enterprise system ensures data security with role-based access control,
                                    encrypted communications, and regular security audits to protect your information.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-12 rounded-lg bg-gradient-to-r from-[#1E40AF] to-blue-600 p-8 text-white dark:from-blue-800 dark:to-blue-900">
                        <div class="grid gap-8 md:grid-cols-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold">500+</div>
                                <div class="mt-2 text-sm">Employees</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">38 Years</div>
                                <div class="mt-2 text-sm">Industry Experience</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">50+</div>
                                <div class="mt-2 text-sm">Countries Served</div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-gray-600 dark:text-gray-300">
                    <p class="mb-2">© 2026 Monti Textile Manufacturing Co. All rights reserved.</p>
                    <p>Enterprise Management System v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
                    <div class="mt-4 flex justify-center space-x-6">
                        <a href="#" class="text-gray-500 hover:text-[#1E40AF]">Contact</a>
                        <a href="#" class="text-gray-500 hover:text-[#1E40AF]">Privacy Policy</a>
                        <a href="#" class="text-gray-500 hover:text-[#1E40AF]">Terms of Service</a>
                        <a href="#" class="text-gray-500 hover:text-[#1E40AF]">Support</a>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>