<script setup>

defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="listing.title" />

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <Link href="/" class="text-indigo-600 hover:text-indigo-500">
                    ← Back to Home
                </Link>
            </div>
        </header>

        <!-- Content -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                            <!-- Image -->
                            <div>
                                <img
                                    v-if="listing.picture"
                                    :src="`/storage/${listing.picture}`"
                                    :alt="listing.title"
                                    class="w-full rounded-lg object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-96 w-full items-center justify-center rounded-lg bg-gray-200"
                                >
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            </div>

                            <!-- Details -->
                            <div>
                                <div class="mb-4">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        {{ listing.category.name }}
                                    </span>
                                    <span
                                        class="ml-2 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium"
                                        :class="{
                                            'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20': listing.condition === 'new',
                                            'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20': listing.condition === 'used',
                                        }"
                                    >
                                        {{ listing.condition }}
                                    </span>
                                </div>

                                <h1 class="mb-4 text-3xl font-bold text-gray-900">
                                    {{ listing.title }}
                                </h1>

                                <div class="mb-6 text-4xl font-bold text-indigo-600">
                                    ${{ listing.price }}
                                </div>

                                <div class="mb-6">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900">Description</h2>
                                    <p class="whitespace-pre-wrap text-gray-700">{{ listing.description }}</p>
                                </div>

                                <div class="space-y-3 border-t border-gray-200 pt-6">
                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-gray-700">{{ listing.location }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <a :href="`tel:${listing.contact_phone}`" class="text-indigo-600 hover:text-indigo-500">
                                            {{ listing.contact_phone }}
                                        </a>
                                    </div>

                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-gray-700">Posted by {{ listing.user.name }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-gray-700">
                                            Posted on {{ new Date(listing.created_at).toLocaleDateString() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <a
                                        :href="`tel:${listing.contact_phone}`"
                                        class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Contact Seller
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
