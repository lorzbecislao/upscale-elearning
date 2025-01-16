<script setup>
import { SearchIcon } from "@heroicons/vue/outline"

const props = defineProps({
    modelValue: String,
    placeholder: { type: String, default: "" },
    size: { type: String, default: "" },
})
</script>
<template>
    <div>
        <label class="sr-only">Search</label>
        <div class="relative">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 pl-4 flex items-center">
                <search-icon class="w-5 h-5 shrink-0 text-medium-gray" />
            </div>
            <input :class="size === 'large' ? 'w-full' : 'lg:w-96 w-full'" :placeholder="placeholder" autocomplete="off"
                class="block bg-white py-3 font-heading pl-10 pr-3 border border-medium-gray shadow-sm rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-transparent sm:text-sm"
                @input="$emit('update:modelValue', $event.target.value)" />
        </div>
    </div>
</template>
