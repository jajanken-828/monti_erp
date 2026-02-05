<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
// ... all your other imports
</script>

<template>

    <Head title="HRM Employee Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6">
            <Badge variant="outline" class="ml-2 font-medium border-blue-200 text-blue-700 bg-blue-50">
                Staff Access
            </Badge>

        </div>
    </AuthenticatedLayout>
</template>