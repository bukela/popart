<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Head title="Manage Users"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('admin.dashboard')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Back to Dashboard
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Manage Users
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Users Management</h3>
                        <p class="mt-2 text-gray-600">This page will be implemented later.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
