<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    listings: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="My Listings" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    My Listings
                </h2>
                <Link
                    :href="route('listings.create')"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create New Listing
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="listings.length === 0" class="text-center py-8">
                            <p class="text-gray-500 mb-4">You haven't created any listings yet.</p>
                            <Link
                                :href="route('listings.create')"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Create Your First Listing
                            </Link>
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="listing in listings"
                                :key="listing.id"
                                class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0"
                            >
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <Link
                                            :href="route('listings.show', listing.id)"
                                            class="text-lg font-medium text-indigo-600 hover:text-indigo-500"
                                        >
                                            {{ listing.title }}
                                        </Link>
                                        <span
                                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium"
                                            :class="{
                                                'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20': listing.status === 'active',
                                                'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20': listing.status === 'sold',
                                                'bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20': listing.status === 'inactive',
                                            }"
                                        >
                                            {{ listing.status }}
                                        </span>
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            {{ listing.condition }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ listing.category.name }} • {{ listing.location }} • ${{ listing.price }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Created {{ new Date(listing.created_at).toLocaleDateString() }}
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <Link
                                        :href="route('listings.edit', listing.id)"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="route('listings.destroy', listing.id)"
                                        method="delete"
                                        as="button"
                                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                                        @click.prevent="
                                            if (confirm('Are you sure you want to delete this listing?')) {
                                                $event.target.click();
                                            }
                                        "
                                    >
                                        Delete
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
