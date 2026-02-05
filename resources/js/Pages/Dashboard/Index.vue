<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import { getDashboardPath } from '@/lib/utils';

const page = usePage();
const user = computed(() => page.props.auth.user);

// Redirect to role-based dashboard
onMounted(() => {
    if (user.value) {
        const path = getDashboardPath(user.value);
        router.visit(path, { replace: true });
    }
});
</script>

<template>
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900 mx-auto"></div>
            <p class="mt-4 text-gray-600">Redirecting to your dashboard...</p>
        </div>
    </div>
</template>