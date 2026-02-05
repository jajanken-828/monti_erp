<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Monti Textile - Login" />

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-[#1E40AF] dark:text-blue-400">Monti Textile</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Manufacturing Management System</p>
        </div>

        <div v-if="status"
            class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="Email Address" class="text-gray-700 dark:text-gray-300" />

                <TextInput id="email" type="email"
                    class="mt-1 block w-full border-gray-300 focus:border-[#1E40AF] focus:ring-[#1E40AF] dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    v-model="form.email" required autofocus autocomplete="username"
                    placeholder="employee@montitextile.com" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" class="text-gray-700 dark:text-gray-300" />

                <TextInput id="password" type="password"
                    class="mt-1 block w-full border-gray-300 focus:border-[#1E40AF] focus:ring-[#1E40AF] dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    v-model="form.password" required autocomplete="current-password" placeholder="••••••••" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember"
                        class="border-gray-300 text-[#1E40AF] focus:ring-[#1E40AF] dark:border-gray-600" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">
                        Remember me
                    </span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-[#1E40AF] hover:text-[#1E3A8A] hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                    Forgot your password?
                </Link>
            </div>

            <PrimaryButton
                class="w-full justify-center bg-[#1E40AF] hover:bg-[#1E3A8A] focus:bg-[#1E3A8A] dark:bg-blue-600 dark:hover:bg-blue-700"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <span v-if="form.processing" class="inline-flex items-center">
                    <svg class="mr-2 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>
                    Signing in...
                </span>
                <span v-else>Sign in to your account</span>
            </PrimaryButton>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <Link :href="route('register')"
                        class="font-medium text-[#1E40AF] hover:text-[#1E3A8A] hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                        Register here
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>