<script setup>
import {usePage, Head} from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';
</script>

<template>
    <Head title="Success" />

    <AuthLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Success
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sn sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <span class="font-bold">Price:</span> ${{ usePage().props.price }}
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>