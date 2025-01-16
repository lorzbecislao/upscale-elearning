<script setup>
import {ChatAltIcon} from "@heroicons/vue/outline"
import {useForm, usePage} from "@inertiajs/vue3"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import TextInput from "@/Components/Shared/TextInput.vue"

const emits = defineEmits(['cancel'])

const props = defineProps({
  comment: Object
})

const form = useForm({
  reply: null
})

function cancel() {
  emits('cancel')
  form.reply = null
}

function submit() {
  let url = usePage().props.auth.user.user_type === 2 ? 'forums.commentReply' : 'admin.forums.commentReply'
  form.post(route(url, props.comment.id), {
    onSuccess: () => {
      form.reply = null
    },
    preserveScroll: true
  })
}
</script>
<template>
  <div class="bg-white border border-gray-200 rounded-lg shadow-lg py-5 px-14">
    <form @submit.prevent="submit">
      <div class="pt-4">
        <text-input :max="256"
                    v-model="form.reply"
                    input-class="!border-[#DFE4EA]"
                    placeholder="Type here your wise reply"
                    :required="true"/>
      </div>
      <div class="mt-6 flex justify-end gap-6">
        <secondary-button class="text-gray-dark" type="button" @click="cancel">
          Cancel
        </secondary-button>
        <primary-button type="submit" class="!bg-secondary">
          <chat-alt-icon class="w-5 h-5"/>
          Reply
        </primary-button>
      </div>
    </form>
  </div>
</template>