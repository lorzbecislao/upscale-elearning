
<script setup>

const props = defineProps({
    disabled: { type: Boolean, default: false },
})

</script>

<template>
    <button :disabled="disabled" :class="disabled ? 'cursor-not-allowed opacity-50' : 'cursor-pointer opacity-100'"
        class="inline-flex items-center justify-center font-medium font-heading px-4 py-2.5 gap-2 text-dark-gray-dark border border-medium-gray hover:bg-[#F2F2F2] rounded-md">
        <slot />
    </button>
</template>
