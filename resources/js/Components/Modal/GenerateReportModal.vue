<script setup>
import {reactive, ref} from "vue"
import DateInput from "@/Components/Shared/DateInput.vue"
import DownloadIcon from "@/Components/Icon/DownloadIcon.vue"
import Modal from "@/Components/Shared/Modal.vue"
import Moment from "moment"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import SelectInput from "@/Components/Shared/SelectInput.vue"

const emits = defineEmits(['close'])

const props = defineProps({
    open: Boolean,
    type: String,
    programs: Array
})


const filters = reactive({
  program: null,
  course: null,
  enrolled_from: null,
  enrolled_till: null,
})

const is_processing = ref(false)

function generate() {
  is_processing.value = true
  axios({
    method: 'post',
    url: 'reports/' + props.type,
    responseType: 'arraybuffer',
    data: {
      'filters': filters,
    }
  }).then(function (response) {
    let blob = new Blob([response.data])
    let link = document.createElement('a')
    link.href = window.URL.createObjectURL(blob)
    let date_now = Moment(new Date).format('YYYY-MM-DD')
    link.download = props.type + '-' + date_now + '.xlsx'
    link.click()
    is_processing.value = false
    emits('close')
  })
}

</script>
<template>
  <Modal :open="open" @close="emits('close')">
    <template v-slot:content>
      <h5 class="font-heading font-bold text-lg">
        Generate Reports
      </h5>
      <div v-if="type === 'students'" class="pt-6">
        <select-input id="select-program"
                      label="Program"
                      v-model="filters.program"
                      :value="filters.program">
          <option v-for="(program, index) in programs" :key="index"
                  :value=program.value>
            {{ program.label }}
          </option>
        </select-input>
      </div>
      <div class="mt-6 border-t border-gray-200">
        <h6 class="font-heading text-base font-medium mt-4">
        Date
        </h6>
        <div class="grid grid-cols-2 gap-6">
          <div class="mt-2">
            <date-input v-model="filters.enrolled_from" label="Date Created From" placeholder="Select Date"/>
          </div>
          <div class="mt-2">
            <date-input v-model="filters.enrolled_till" label="Date Created To" placeholder="Select Date"/>
          </div>
        </div>
      </div>
      <div class="pt-6 flex justify-end gap-6">
        <secondary-button @click="emits('close')">
          Cancel
        </secondary-button>
        <primary-button :disabled="is_processing" @click="generate">
          <download-icon class="w-5 h-5"/>
          Download
        </primary-button>
      </div>
    </template>
  </Modal>
</template>