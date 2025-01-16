<script setup>
import {v4 as uuid} from 'uuid'
import Datepicker from 'vue3-datepicker'
import { reactive, ref} from 'vue'
import CalendarIcon from "@/Components/Icon/CalendarIcon.vue"

defineOptions({
  inheritAttrs: false,
})

const props = defineProps({
  id: {
    type: String,
    default() {
      return `date-input-${uuid()}`
    },
  },
  value: [String, Number, Date],
  label: String,
  disabled: Boolean,
  errors: {
    type: Array,
    default: () => [],
  },
  max_date: {
    type: [Date, String],
    default: null
  },
  min_date: {
    type: [Date, String],
    default: null
  },
  reset_date: Boolean,
  required: {
    type: Boolean,
    default: true
  },
  placeholder: {type: String, default: ''},
})

const date_selected = ref()
const datepicker = ref()
const datepicker_style = ref({
  '--elem-selected-bg-color': '#1c375b',
  '--elem-hover-bg-color': '#1c375b',
  'border-radius': '8px',
  'border-color': '#8F8F8F',
  'margin-top': '4px',
  'padding-top': '8px',
  'padding-bottom': '8px',
  'font-size': '14px',
  'font-family': 'DM Sans',
  'line-height': '1.25rem',

},)

const input = ref('')
const state = reactive({
  disabledDates: {
    from: new Date(),
  }
})


</script>
<template>
  <div>
    <div class="flex justify-between">
      <label v-if="label" :for="id"
             class="block text-sm font-medium text-dark-gray-dark font-heading">{{ label }}</label>
    </div>
    <div class="relative text-sm text-tenant-darkest">
      <Datepicker id="id"
                  ref="datepicker"
                  v-model="date_selected"
                  :disabled="disabled"
                  inputFormat="MM/dd/yyyy"
                  :lowerLimit="min_date"
                  :upperLimit="max_date"
                  :style="datepicker_style"
                  :required="required"
                  :typeable="true"
                  :use-utc="true"
                  :placeholder="placeholder"
                  v-bind="$attrs"
                  @select="$emit('update:modelValue', date_selected)"/>
      <div class="cursor-pointer absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
        <calendar-icon class="h-5 w-5"/>
      </div>
    </div>
  </div>
</template>
<style>
input, select {
  width: 100%;
  z-index: 30;
}

.v3dp__popout[data-v-2e128338] {
  z-index: 100 !important;
}
</style>

