<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import CategoryOption from '@/Components/CategoryOption.vue';

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const searchParams = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    location: props.filters.location || '',
    min_price: props.filters.min_price || '',
    max_price: props.filters.max_price || '',
});

let debounceTimer = null;

const debouncedSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        updateUrl();
    }, 500);
};

const updateUrl = () => {
    const params = Object.fromEntries(
        Object.entries(searchParams.value).filter(([_, value]) => value !== '')
    );

    router.get('/', params, {
        preserveState: true,
        preserveScroll: true,
    });
};

watch(() => ({
    category: searchParams.value.category,
    location: searchParams.value.location,
    min_price: searchParams.value.min_price,
    max_price: searchParams.value.max_price,
}), () => {
    updateUrl();
}, { deep: true });

watch(() => searchParams.value.search, (newValue) => {
    if (newValue.length === 0 || newValue.length >= 3) {
        debouncedSearch();
    }
});

const clearFilters = () => {
    searchParams.value = {
        search: '',
        category: '',
        location: '',
        min_price: '',
        max_price: '',
    };
    updateUrl();
};

</script>

<template>
    <Head title="PopArt Listings" />

    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow">

            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">PopArt Listings</h1>
                    </div>

                    <nav class="flex items-center gap-4">
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('profile.listings')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                My Listings
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-sm font-semibold text-gray-900 hover:text-indigo-600"
                            >
                                Log in
                            </Link>
                            <Link
                                :href="route('register')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Search Filters -->
        <section class="bg-white border-b">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input
                                v-model="searchParams.search"
                                type="text"
                                placeholder="Search listings (min 3 characters)..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input
                                v-model="searchParams.location"
                                type="text"
                                placeholder="City or area..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                            <input
                                v-model="searchParams.min_price"
                                type="number"
                                placeholder="0"
                                min="0"
                                step="0.01"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                            <input
                                v-model="searchParams.max_price"
                                type="number"
                                placeholder="10000"
                                min="0"
                                step="0.01"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select
                                v-model="searchParams.category"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="">All Categories</option>
                                <CategoryOption
                                    v-for="category in categories"
                                    :key="category.id"
                                    :category="category"
                                    :level="0"
                                />
                            </select>
                        </div>

                        <button
                            @click="clearFilters"
                            class="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500"
                        >
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Latest Listings</h2>
                <p class="mt-2 text-gray-600">Browse through our collection of active listings</p>
            </div>

            <!-- Listings Grid -->
            <div v-if="listings.data.length > 0" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="listing in listings.data"
                        :key="listing.id"
                        :href="route('listings.show', listing.id)"
                        class="group overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 transition hover:shadow-md"
                    >
                        <div class="aspect-h-3 aspect-w-4 relative overflow-hidden bg-gray-200">
                            <img
                                v-if="listing.picture"
                                :src="`/storage/${listing.picture}`"
                                :alt="listing.title"
                                class="h-48 w-full object-cover transition group-hover:scale-105"
                            />
                            <div
                                v-else
                                class="flex h-48 w-full items-center justify-center bg-gray-200"
                            >
                                <span class="text-gray-400">No image</span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="mb-2 flex items-center gap-2">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ listing.category.name }}
                                </span>
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium"
                                    :class="{
                                        'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20': listing.condition === 'new',
                                        'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20': listing.condition === 'used',
                                    }"
                                >
                                    {{ listing.condition }}
                                </span>
                            </div>

                            <h3 class="mb-2 text-lg font-semibold text-gray-900 group-hover:text-indigo-600">
                                {{ listing.title }}
                            </h3>

                            <p class="mb-3 line-clamp-2 text-sm text-gray-600">
                                {{ listing.description }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-indigo-600">
                                    ${{ listing.price }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ listing.location }}
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div v-if="listings.links.length > 3" class="mt-8 flex justify-center">
                    <nav class="inline-flex rounded-md shadow-sm -space-x-px">
                        <Link
                            v-for="(link, index) in listings.links"
                            :key="index"
                            :href="link.url || '#'"
                            :class="[
                                'relative inline-flex items-center px-4 py-2 text-sm font-medium',
                                link.active
                                    ? 'z-10 bg-indigo-600 text-white'
                                    : 'bg-white text-gray-700 hover:bg-gray-50',
                                index === 0 ? 'rounded-l-md' : '',
                                index === listings.links.length - 1 ? 'rounded-r-md' : '',
                                !link.url ? 'cursor-not-allowed opacity-50' : '',
                            ]"
                            :disabled="!link.url"
                            v-html="link.label"
                        />
                    </nav>
                </div>
            </div>

            <div v-else class="rounded-lg bg-white p-12 text-center shadow-sm">
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No listings yet</h3>
                <p class="mt-1 text-sm text-gray-500">Be the first to create a listing!</p>
                <div class="mt-6">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('listings.create')"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                    >
                        Create Listing
                    </Link>
                    <Link
                        v-else
                        :href="route('register')"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                    >
                        Register to Post
                    </Link>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-12 border-t border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    © {{ new Date().getFullYear() }} PopArt Listings. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>
