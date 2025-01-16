<script setup>

const props = defineProps({
    disabled: { type: Boolean, default: false },
})

</script>

<template>
    <button :disabled="disabled" :class="disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer opacity-100'"
        class="inline-flex items-center font-medium justify-center font-heading px-4 py-2.5 gap-2 text-white border border-transparent bg-primary rounded-md hover:bg-primary-darker">
        <slot />
    </button>
</template>
