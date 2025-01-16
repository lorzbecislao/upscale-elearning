<script setup>
const props = defineProps({
    active: Boolean,
})

</script>
<template>
    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g :opacity="active ? 1 : 0.2">
            <path d="M13.3333 4.5L5.99996 11.8333L2.66663 8.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </g>
    </svg>
</template>