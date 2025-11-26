<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Admin Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <!-- Listings Card -->
                    <Link
                        :href="route('home')"
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-md transition-shadow"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Listings
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_listings }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-sm font-medium text-green-600 hover:text-green-500">
                                    View all listings →
                                </span>
                            </div>
                        </div>
                    </Link>

                    <!-- Users Card -->
                    <Link
                        :href="route('admin.users.index')"
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-md transition-shadow"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Users
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_users }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    Manage users →
                                </span>
                            </div>
                        </div>
                    </Link>

                    <!-- Categories Card -->
                    <Link
                        :href="route('admin.categories.index')"
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-md transition-shadow"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-purple-500" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Categories
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total_categories }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="text-sm font-medium text-purple-600 hover:text-purple-500">
                                    Manage categories →
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
