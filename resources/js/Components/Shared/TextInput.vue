<script setup>
import {v4 as uuid} from 'uuid'
import {computed, onMounted, ref} from 'vue'
import {usePage} from "@inertiajs/vue3"
import ExclamationCircleIcon from '@/Components/Icon/ExclamationCircleIcon.vue'

defineEmits(['update:modelValue']);

defineProps({
  disabled: Boolean,
  errors: {
    type: Array,
    default: () => [],
  },
  id: {
    type: String,
    default() {
      return `text-input-${uuid()}`
    },
  },
  type: {
    type: String,
    default: 'text',
  },
  inputClass: {type: String, default: ''},
  label: String,
  modelValue: [String, Number],
  optional: Boolean,
  placeholder: String,
  required: {type: Boolean, default: false},
  max: {
    type: Number,
  },
  min: {
    type: Number,
  },
  minVal: {
    type: Number,
  },
  borderless: {type: Boolean, default: false},
});

defineOptions({
  inheritAttrs: false,
})

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
  <div>
    <label v-if="label" class="block text-sm font-medium font-heading text-dark-gray-dark" :for="id">
      {{ label }}
      <span v-if="optional" class="ml-1">(Optional)</span>
    </label>

    <div class="mt-1 relative rounded-md shadow-sm">
      <input :style="borderless ? 'border: none;' : 'border: 1px solid #878CA6;'"
             class="mt-1 form-input block w-full py-2.5 px-3 focus:ring-primary border border-medium-gray font-heading rounded-md shadow-sm focus:outline-none focus:ring-1 focus:border-transparent text-sm"
             :class="[{ 'bg-gray-100 text-gray-500': disabled }, inputClass, errors.length > 0 ? 'border-red-error' : '']"
             :id="id"
             :placeholder="placeholder"
             ref="input"
             :disabled="disabled"
             :maxlength="max"
             :minlength="min"
             :min="minVal"
             :required="required"
             :type="type"
             :value="modelValue"
             v-bind="{ ...$attrs, class: null }"
             @input="$emit('update:modelValue', $event.target.value)"/>

      <div v-if="errors.length"
           class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
        <ExclamationCircleIcon class="text-red-error"/>
      </div>
    </div>
    <p v-if="errors.length" class="mt-2 text-sm text-red-600">{{ errors[0] }}</p>
  </div>
</template>
<style scoped>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  -moz-appearance: none;
  margin: 5px;
}

input[type='number'] {
  -moz-appearance: textfield;
}
</style>
