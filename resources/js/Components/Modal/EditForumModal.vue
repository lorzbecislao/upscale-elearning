<script setup>
import {useForm, usePage} from "@inertiajs/vue3"
import {ref} from "vue"
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import SelectInput from "@/Components/Shared/SelectInput.vue"
import TextInput from "@/Components/Shared/TextInput.vue"


const emits = defineEmits(['close'])

const props = defineProps({
  courses: Array,
  forum: Object,
  open: Boolean,

})

const form = useForm({
  course_id: props.forum.course_id,
  title: props.forum.title,
  question: props.forum.question,
})

const stringCount = ref(form.question.length)

function handleQuestionCount() {
  stringCount.value = form.question.length
}

function submit() {
  let url = usePage().props.auth.user.user_type === 2 ? 'forums.update' : 'admin.forums.update'
  form.post(route(url, props.forum.id), {
    onSuccess: () => {
      emits('close')
    }
  })
}


</script>
<template>
  <Modal :open="open" @close="emits('close')">
    <template v-slot:content>
      <h5 class="font-heading font-bold text-black-darkest">
        Edit Post
      </h5>
      <form @submit.prevent="submit">
        <div class="pt-6">
          <select-input id="select-course"
                        label="Course"
                        v-model="form.course_id"
                        :value="form.course_id">
            <option v-for="(course, index) in courses" :key="index"
                    :value=course.id>
              {{ course.name }}
            </option>
          </select-input>
        </div>
        <div class="pt-4">
          <text-input :max="256" v-model="form.title" placeholder="What's your forum title?" :required="true"/>
        </div>
        <div class="pt-4">
            <textarea v-model="form.question"
                      class="mt-1 w-full px-4 py-3 rounded-lg border border-[#878CA6] text-sm font-heading focus:ring-0 focus:border-tenant-medium-dark"
                      placeholder="Type your question ..."
                      :required="true"
                      :maxlength="500"
                      @input="handleQuestionCount"
                      rows="5"/>
          <div class="flex justify-end">
            <p class="text-xs font-heading text-gray-500">{{ stringCount }}/500</p>
          </div>
        </div>
        <div class="mt-4 flex justify-end gap-4">
          <secondary-button type="button" @click="emits('close')">
            Cancel
          </secondary-button>
          <primary-button>
            Save
          </primary-button>
        </div>
      </form>
    </template>
  </Modal>
</template>