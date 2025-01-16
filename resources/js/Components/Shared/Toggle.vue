<script setup>
import { Switch } from '@headlessui/vue'
import { computed } from 'vue';

// emits
const emits = defineEmits(['toggle-value'])

const props = defineProps({
    id: { type: Number, default: null },
    value: { type: Boolean, default: false },
    type: { type: String, default: 'primary' },
    disabled: { type: Boolean, default: false }
})

function toggle() {
    if (!props.disabled) {
        emits('toggle-value', props.id)
    }
}

const switchClass = computed(() => {
    if (props.disabled && props.value) {
        return 'bg-gray-500 cursor-not-allowed'; // Apply disabled class
    } else if (props.value) {
        if (props.type === 'success') {
            return 'bg-green-500';
        } else {
            return 'bg-primary';
        }
    } else {
        if (props.disabled) {
            return 'bg-transparent cursor-not-allowed border border-medium-gray';
        } else {
            return 'bg-transparent cursor-pointer border border-medium-gray';
        }
    }
});


</script>
<template>
    <Switch
        :class="[switchClass, ' relative inline-flex h-7 w-14 flex-shrink-0 rounded-full transition-colors duration-200 ease-in-out']"
        @click="toggle">
        <span class="sr-only">Use setting</span>
        <span
            :class="[value ? 'translate-x-8 translate-y-1 bg-white' : 'translate-x-1 translate-y-[3px] bg-gray-500', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out']">
            <span
                :class="[value ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
                aria-hidden="true">
                <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 12 12">
                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>

            <span
                :class="[value ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
                aria-hidden="true">
                <svg class="h-3 w-3"
                    :class="[type === 'primary' && !disabled ? 'text-primary' : 'text-green-500', { 'text-gray-500': disabled }]"
                    fill="currentColor" viewBox="0 0 12 12">
                    <path
                        d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                </svg>
        </span>
    </span>
</Switch></template>

