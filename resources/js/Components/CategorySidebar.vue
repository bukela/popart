<script setup>
import { ref } from 'vue';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    selectedCategory: {
        type: [String, Number],
        default: '',
    },
});

const emit = defineEmits(['select-category']);

const expandedCategories = ref(new Set());

const toggleCategory = (categoryId) => {
    if (expandedCategories.value.has(categoryId)) {
        expandedCategories.value.delete(categoryId);
    } else {
        expandedCategories.value.add(categoryId);
    }
};

const selectCategory = (categoryId) => {
    emit('select-category', categoryId);
};

const hasChildren = (category) => {
    const children = category.children_recursive || category.childrenRecursive || category.children || [];
    return children.length > 0;
};

const getChildren = (category) => {
    return category.children_recursive || category.childrenRecursive || category.children || [];
};
</script>

<template>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
        
        <div class="space-y-1">
            <button
                @click="selectCategory('')"
                :class="[
                    'w-full text-left px-3 py-2 rounded text-sm font-medium transition',
                    selectedCategory === '' 
                        ? 'bg-indigo-50 text-indigo-700' 
                        : 'text-gray-700 hover:bg-gray-50'
                ]"
            >
                All Categories
            </button>

            <div v-for="category in categories" :key="category.id">
                <div class="flex items-center">
                    <button
                        v-if="hasChildren(category)"
                        @click="toggleCategory(category.id)"
                        class="p-2 hover:bg-gray-100 rounded"
                    >
                        <svg 
                            class="w-4 h-4 text-gray-500 transition-transform"
                            :class="{ 'rotate-90': expandedCategories.has(category.id) }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <button
                        @click="selectCategory(category.id)"
                        :class="[
                            'flex-1 text-left px-3 py-2 rounded text-sm font-medium transition',
                            selectedCategory == category.id 
                                ? 'bg-indigo-50 text-indigo-700' 
                                : 'text-gray-700 hover:bg-gray-50',
                            !hasChildren(category) ? 'ml-10' : ''
                        ]"
                    >
                        {{ category.name }}
                    </button>
                </div>

                <div 
                    v-if="hasChildren(category) && expandedCategories.has(category.id)"
                    class="ml-6 mt-1 space-y-1"
                >
                    <div v-for="child in getChildren(category)" :key="child.id">
                        <div class="flex items-center">
                            <button
                                v-if="hasChildren(child)"
                                @click="toggleCategory(child.id)"
                                class="p-2 hover:bg-gray-100 rounded"
                            >
                                <svg 
                                    class="w-4 h-4 text-gray-500 transition-transform"
                                    :class="{ 'rotate-90': expandedCategories.has(child.id) }"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <button
                                @click="selectCategory(child.id)"
                                :class="[
                                    'flex-1 text-left px-3 py-2 rounded text-sm transition',
                                    selectedCategory == child.id 
                                        ? 'bg-indigo-50 text-indigo-700' 
                                        : 'text-gray-600 hover:bg-gray-50',
                                    !hasChildren(child) ? 'ml-10' : ''
                                ]"
                            >
                                {{ child.name }}
                            </button>
                        </div>

                        <div 
                            v-if="hasChildren(child) && expandedCategories.has(child.id)"
                            class="ml-6 mt-1 space-y-1"
                        >
                            <button
                                v-for="grandchild in getChildren(child)"
                                :key="grandchild.id"
                                @click="selectCategory(grandchild.id)"
                                :class="[
                                    'w-full text-left px-3 py-2 rounded text-sm transition ml-10',
                                    selectedCategory == grandchild.id 
                                        ? 'bg-indigo-50 text-indigo-700' 
                                        : 'text-gray-600 hover:bg-gray-50'
                                ]"
                            >
                                {{ grandchild.name }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
