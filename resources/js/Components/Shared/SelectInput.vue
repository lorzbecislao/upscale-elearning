<script setup>
import {v4 as uuid} from 'uuid'
import {ref, watch} from "vue"

defineOptions({
    inheritAttrs: false,
})

const emit = defineEmits(['update:modelValue'])

const props = defineProps({
    disabled: Boolean,
    errors: {
        type: Array,
        default: () => [],
    },
    id: {
        type: String,
        default() {
            return `select-input-${uuid}`
        },
    },
    label: String,
    placeholder: String,
    required: {type: Boolean, default: false},
    value: [String, Number, Boolean],
})

const input = ref()
const selected = ref(props.value)

watch(selected, (selected) => {
    emit('update:modelValue', selected)
})

function focus() {
    input.value.focus()
}

function select() {
    input.value.select()
}

</script>
<template>
    <div>
        <div class="flex justify-between">
            <label v-if="label"
                   class="block text-sm font-medium text-dark-gray-dark font-heading"
                   :for="id">
                {{ label }}
            </label>
        </div>
        <div class="mt-1 relative rounded-md shadow-sm">
            <select v-model="selected"
                    class="mt-1 block w-full py-2.5 px-3 border border-medium-gray bg-white rounded-md text-sm text-black-darkest shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-transparent sm:leading-5"
                    :class="{ error: errors.length, 'bg-gray-100 text-gray-500' : disabled }"
                    :disabled="disabled"
                    :id="id"
                    ref="input"
                    :required="required"
                    v-bind="$attrs"
                    @select="$emit('update:modelValue', selected)">
                <slot/>
            </select>
        </div>
    </div>
</template>
