<script setup>
import {computed} from 'vue'
import {router, usePage} from '@inertiajs/vue3'

const page = usePage()

const hasErrors = computed(() => {
    return page.props.errors && Object.keys(page.props.errors).length > 0
})

const clearFlash = () => {
    router.reload({
        only: ['flash'],
        preserveState: true
    })
}

const clearErrors = () => {
    router.reload({
        only: ['errors'],
        preserveState: true
    })
}
</script>

<template>
    <div v-if="page.props.flash.success"
         class="mb-4 border-l-4 border-green-500 bg-green-50 p-4 rounded">
        <div class="flex justify-between items-start">
            <p class="text-green-700">{{ page.props.flash.success }}</p>
            <button
                @click="clearFlash"
                class="text-green-500 hover:text-green-700 font-bold text-xl"
            >
                ×
            </button>
        </div>
    </div>

    <div v-if="page.props.flash.error"
         class="mb-4 border-l-4 border-red-500 bg-red-50 p-4 rounded">
        <div class="flex justify-between items-start">
            <p class="text-red-700">{{ page.props.flash.error }}</p>
            <button
                @click="clearFlash"
                class="text-red-500 hover:text-red-700 font-bold text-xl"
            >
                ×
            </button>
        </div>
    </div>

    <div v-if="hasErrors"
         class="mb-4 border-l-4 border-red-500 bg-red-50 p-4 rounded">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <p class="text-red-700 font-medium mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-red-600">
                    <li v-for="(error, field) in page.props.errors" :key="field">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <button
                @click="clearErrors"
                class="text-red-500 hover:text-red-700 font-bold text-xl ml-4"
            >
                ×
            </button>
        </div>
    </div>
</template>
