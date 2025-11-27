<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const showAddModal = ref(false);
const showEditModal = ref(false);
const editingCategory = ref(null);
const parentForNewCategory = ref(null);

const addForm = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: null,
});

const editForm = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: null,
});

const openAddModal = (parentCategory = null) => {
    addForm.reset();
    parentForNewCategory.value = parentCategory;
    addForm.parent_id = parentCategory ? parentCategory.id : null;
    showAddModal.value = true;
};

const openEditModal = (category) => {
    editingCategory.value = category;
    editForm.name = category.name;
    editForm.slug = category.slug;
    editForm.description = category.description || '';
    editForm.parent_id = category.parent_id;
    showEditModal.value = true;
};

const submitAdd = () => {
    addForm.post(route('admin.categories.store'), {
        onSuccess: () => {
            showAddModal.value = false;
            addForm.reset();
        },
    });
};

const submitEdit = () => {
    editForm.put(route('admin.categories.update', editingCategory.value.id), {
        onSuccess: () => {
            showEditModal.value = false;
            editForm.reset();
        },
    });
};

const confirmDelete = (category) => {
    if (confirm(`Are you sure you want to delete "${category.name}"?`)) {
        router.delete(route('admin.categories.destroy', category.id));
    }
};

const generateSlug = (name, form) => {
    form.slug = name
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
};

const getChildren = (category) => {
    return category.children_recursive || category.childrenRecursive || [];
};
</script>

<template>
    <Head title="Manage Categories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link
                        :href="route('admin.dashboard')"
                        class="text-sm text-gray-600 hover:text-gray-900"
                    >
                        ← Back to Dashboard
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Manage Categories
                    </h2>
                </div>
                <button
                    @click="openAddModal()"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                >
                    Add Root Category
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="categories.length === 0" class="text-center py-8 text-gray-500">
                            No categories yet. Click "Add Root Category" to create one.
                        </div>

                        <div v-else class="space-y-4">
                            <template v-for="category in categories" :key="category.id">
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
                                            <p class="text-sm text-gray-500">{{ category.slug }}</p>
                                            <p v-if="category.description" class="text-sm text-gray-600 mt-1">{{ category.description }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button
                                                @click="openAddModal(category)"
                                                class="rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                                                title="Add subcategory"
                                            >
                                                + Add Child
                                            </button>
                                            <button
                                                @click="openEditModal(category)"
                                                class="rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="confirmDelete(category)"
                                                class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                    <div v-if="getChildren(category).length > 0" class="mt-4 ml-8 space-y-3">
                                        <template v-for="child in getChildren(category)" :key="child.id">
                                            <div class="border-l-2 border-gray-300 pl-4">
                                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                                                    <div class="flex-1">
                                                        <h4 class="font-medium text-gray-900">{{ child.name }}</h4>
                                                        <p class="text-sm text-gray-500">{{ child.slug }}</p>
                                                        <p v-if="child.description" class="text-sm text-gray-600 mt-1">{{ child.description }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <button
                                                            @click="openAddModal(child)"
                                                            class="rounded-md bg-green-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-green-500"
                                                            title="Add subcategory"
                                                        >
                                                            + Add Child
                                                        </button>
                                                        <button
                                                            @click="openEditModal(child)"
                                                            class="rounded-md bg-blue-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-blue-500"
                                                        >
                                                            Edit
                                                        </button>
                                                        <button
                                                            @click="confirmDelete(child)"
                                                            class="rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-red-500"
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>

                                                <div v-if="getChildren(child).length > 0" class="mt-3 ml-8 space-y-2">
                                                    <template v-for="grandchild in getChildren(child)" :key="grandchild.id">
                                                        <div class="border-l-2 border-gray-200 pl-4">
                                                            <div class="flex items-center justify-between bg-gray-100 p-2 rounded">
                                                                <div class="flex-1">
                                                                    <h5 class="text-sm font-medium text-gray-900">{{ grandchild.name }}</h5>
                                                                    <p class="text-xs text-gray-500">{{ grandchild.slug }}</p>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    <button
                                                                        @click="openAddModal(grandchild)"
                                                                        class="rounded-md bg-green-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-green-500"
                                                                        title="Add subcategory"
                                                                    >
                                                                        +
                                                                    </button>
                                                                    <button
                                                                        @click="openEditModal(grandchild)"
                                                                        class="rounded-md bg-blue-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-blue-500"
                                                                    >
                                                                        Edit
                                                                    </button>
                                                                    <button
                                                                        @click="confirmDelete(grandchild)"
                                                                        class="rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-red-500"
                                                                    >
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showAddModal = false"></div>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <form @submit.prevent="submitAdd">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                            Add {{ parentForNewCategory ? 'Subcategory to ' + parentForNewCategory.name : 'Root Category' }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="add-name" class="block text-sm font-medium text-gray-700">Name *</label>
                                <input
                                    id="add-name"
                                    v-model="addForm.name"
                                    @input="generateSlug(addForm.name, addForm)"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div v-if="addForm.errors.name" class="mt-1 text-sm text-red-600">{{ addForm.errors.name }}</div>
                            </div>

                            <div>
                                <label for="add-slug" class="block text-sm font-medium text-gray-700">Slug *</label>
                                <input
                                    id="add-slug"
                                    v-model="addForm.slug"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div v-if="addForm.errors.slug" class="mt-1 text-sm text-red-600">{{ addForm.errors.slug }}</div>
                            </div>

                            <div>
                                <label for="add-description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea
                                    id="add-description"
                                    v-model="addForm.description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                ></textarea>
                                <div v-if="addForm.errors.description" class="mt-1 text-sm text-red-600">{{ addForm.errors.description }}</div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <button
                                type="submit"
                                :disabled="addForm.processing"
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2"
                            >
                                Create
                            </button>
                            <button
                                type="button"
                                @click="showAddModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showEditModal = false"></div>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <form @submit.prevent="submitEdit">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                            Edit Category
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="edit-name" class="block text-sm font-medium text-gray-700">Name *</label>
                                <input
                                    id="edit-name"
                                    v-model="editForm.name"
                                    @input="generateSlug(editForm.name, editForm)"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div v-if="editForm.errors.name" class="mt-1 text-sm text-red-600">{{ editForm.errors.name }}</div>
                            </div>

                            <div>
                                <label for="edit-slug" class="block text-sm font-medium text-gray-700">Slug *</label>
                                <input
                                    id="edit-slug"
                                    v-model="editForm.slug"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div v-if="editForm.errors.slug" class="mt-1 text-sm text-red-600">{{ editForm.errors.slug }}</div>
                            </div>

                            <div>
                                <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea
                                    id="edit-description"
                                    v-model="editForm.description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                ></textarea>
                                <div v-if="editForm.errors.description" class="mt-1 text-sm text-red-600">{{ editForm.errors.description }}</div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <button
                                type="submit"
                                :disabled="editForm.processing"
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2"
                            >
                                Update
                            </button>
                            <button
                                type="button"
                                @click="showEditModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
