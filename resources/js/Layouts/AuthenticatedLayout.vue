<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Navbar from '@/Layouts/Navbar/Navbar.vue';

defineProps({
    user: Object,
});

const navigation = computed(() => {
    const user = usePage().props.auth.user;
    const baseNav = [
        { name: 'Dashboard', href: route('dashboard'), current: route().current('dashboard.*') },
    ];

    // HRM Navigation
    if (user.role === 'HRM') {
        if (user.position === 'manager') {
            baseNav.push(
                { name: 'Team Management', href: route('hrm.team.index'), current: route().current('hrm.team.*') },
                { name: 'Recruitment', href: route('hrm.recruitment.index'), current: route().current('hrm.recruitment.*') },
                { name: 'Reports', href: route('hrm.reports.index'), current: route().current('hrm.reports.*') },
                { name: 'Analytics', href: route('hrm.analytics.index'), current: route().current('hrm.analytics.*') }
            );
        } else {
            baseNav.push(
                { name: 'My Tasks', href: route('hrm.employee.tasks'), current: route().current('hrm.employee.tasks') },
                { name: 'Attendance', href: route('hrm.employee.attendance'), current: route().current('hrm.employee.attendance') },
                { name: 'Leave', href: route('hrm.employee.leave'), current: route().current('hrm.employee.leave') }
            );
        }
    }

    // SCM Navigation
    if (user.role === 'SCM') {
        if (user.position === 'manager') {
            baseNav.push(
                { name: 'Inventory', href: route('scm.inventory.index'), current: route().current('scm.inventory.*') },
                { name: 'Suppliers', href: route('scm.suppliers.index'), current: route().current('scm.suppliers.*') },
                { name: 'Orders', href: route('scm.orders.index'), current: route().current('scm.orders.*') },
                { name: 'Logistics', href: route('scm.logistics.index'), current: route().current('scm.logistics.*') }
            );
        } else {
            baseNav.push(
                { name: 'Inventory', href: route('scm.employee.inventory'), current: route().current('scm.employee.inventory') },
                { name: 'Orders', href: route('scm.employee.orders'), current: route().current('scm.employee.orders') },
                { name: 'Delivery', href: route('scm.employee.delivery'), current: route().current('scm.employee.delivery') }
            );
        }
    }

    // Common navigation
    baseNav.push(
        { name: 'Profile', href: route('profile.edit'), current: route().current('profile.edit') }
    );

    return baseNav;
});
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <Navbar :navigation="navigation" :user="user" />

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>