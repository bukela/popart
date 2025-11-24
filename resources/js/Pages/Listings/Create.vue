<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    category_id: '',
    title: '',
    description: '',
    price: '',
    condition: 'used',
    picture: null,
    contact_phone: '',
    location: '',
});

const submit = () => {
    form.post(route('listings.store'), {
        forceFormData: true,
    });
};

const handleFileChange = (event) => {
    form.picture = event.target.files[0];
};

const getAllCategories = (categories, level = 0) => {
    let result = [];
    categories.forEach(category => {
        result.push({ ...category, level });
        if (category.children && category.children.length > 0) {
            result = result.concat(getAllCategories(category.children, level + 1));
        }
    });
    return result;
};

const flatCategories = getAllCategories(props.categories);
</script>

<template>
    <Head title="Create Listing" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create New Listing
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Category -->
                        <div>
                            <InputLabel for="category_id" value="Category *" />
                            <select
                                id="category_id"
                                v-model="form.category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="">Select a category</option>
                                <option
                                    v-for="category in flatCategories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ '—'.repeat(category.level) }} {{ category.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id" />
                        </div>

                        <!-- Title -->
                        <div>
                            <InputLabel for="title" value="Title *" />
                            <TextInput
                                id="title"
                                type="text"
                                v-model="form.title"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <!-- Description -->
                        <div>
                            <InputLabel for="description" value="Description *" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                rows="4"
                                required
                            ></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <!-- Price -->
                        <div>
                            <InputLabel for="price" value="Price ($) *" />
                            <TextInput
                                id="price"
                                type="number"
                                step="0.01"
                                min="0"
                                v-model="form.price"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.price" />
                        </div>

                        <!-- Condition -->
                        <div>
                            <InputLabel for="condition" value="Condition *" />
                            <select
                                id="condition"
                                v-model="form.condition"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="new">New</option>
                                <option value="used">Used</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.condition" />
                        </div>

                        <!-- Picture -->
                        <div>
                            <InputLabel for="picture" value="Picture" />
                            <input
                                id="picture"
                                type="file"
                                accept="image/*"
                                @change="handleFileChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            />
                            <InputError class="mt-2" :message="form.errors.picture" />
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <InputLabel for="contact_phone" value="Contact Phone *" />
                            <TextInput
                                id="contact_phone"
                                type="tel"
                                v-model="form.contact_phone"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.contact_phone" />
                        </div>

                        <!-- Location -->
                        <div>
                            <InputLabel for="location" value="Location *" />
                            <TextInput
                                id="location"
                                type="text"
                                v-model="form.location"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.location" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-4">
                            <PrimaryButton :disabled="form.processing">
                                Create Listing
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
