<script setup>
import {router, usePage} from '@inertiajs/vue3'

const page = usePage()

const clearFlash = () => {
    router.reload({
        only: ['flash', 'errors'],
        preserveState: true
    })
}
</script>

<template>
    <div class="fixed top-4 right-4 z-50 max-w-md space-y-2">
        <div v-if="page.props.flash.success"
             class="border-l-4 border-green-500 bg-green-50 p-4 rounded shadow-lg">
            <div class="flex justify-between items-start">
                <p class="text-green-700">{{ page.props.flash.success }}</p>
                <button
                    @click="clearFlash"
                    class="text-green-500 hover:text-green-700 font-bold text-xl ml-4"
                >
                    ×
                </button>
            </div>
        </div>

    </div>
</template>
