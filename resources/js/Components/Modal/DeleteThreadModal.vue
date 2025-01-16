<script setup>
import Modal from "@/Components/Shared/Modal.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import { router, usePage } from "@inertiajs/vue3";

const emits = defineEmits(['close'])

const props = defineProps({
  forum: Object,
  open: Boolean
})

function deleteThread() {
    let url = usePage().props.auth.user.user_type === 2 ? 'forums.delete' : 'admin.forums.delete'
    router.post(route(url, props.forum.id), null, {
        onSuccess: () => {
            emits('close')

        }
    })
}
</script>
<template>
  <Modal :open="open" :closable="false" @close="emits('close')">
    <template v-slot:content>
      <div class="p-6 flex flex-col items-center gap-5">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="60" height="60" rx="30" fill="#FEEBEB"/>
          <path
              d="M40.6875 33.4871L32.6625 20.5746C32.025 19.7121 31.05 19.2246 30 19.2246C28.9125 19.2246 27.9375 19.7121 27.3375 20.5746L19.3125 33.4871C18.5625 34.4996 18.45 35.8121 19.0125 36.9371C19.575 38.0621 20.7 38.7746 21.975 38.7746H38.025C39.3 38.7746 40.425 38.0621 40.9875 36.9371C41.55 35.8496 41.4375 34.4996 40.6875 33.4871ZM39.4875 36.1871C39.1875 36.7496 38.6625 37.0871 38.025 37.0871H21.975C21.3375 37.0871 20.8125 36.7496 20.5125 36.1871C20.25 35.6246 20.2875 34.9871 20.6625 34.4996L28.6875 21.5871C28.9875 21.1746 29.475 20.9121 30 20.9121C30.525 20.9121 31.0125 21.1371 31.3125 21.5871L39.3375 34.4996C39.7125 34.9871 39.75 35.6246 39.4875 36.1871Z"
              fill="#E10E0E"/>
          <path
              d="M30 26.1992C29.55 26.1992 29.1375 26.5742 29.1375 27.0617V31.1492C29.1375 31.5992 29.5125 32.0117 30 32.0117C30.4875 32.0117 30.8625 31.6367 30.8625 31.1492V27.0242C30.8625 26.5742 30.45 26.1992 30 26.1992Z"
              fill="#E10E0E"/>
          <path
              d="M30 33C29.55 33 29.1375 33.375 29.1375 33.8625V34.05C29.1375 34.5 29.5125 34.9125 30 34.9125C30.4875 34.9125 30.8625 34.5375 30.8625 34.05V33.825C30.8625 33.375 30.45 33 30 33Z"
              fill="#E10E0E"/>
        </svg>
        <div class="text-center">
          <h5 class="text-2xl font-semibold font-heading text-gray-900">Delete Thread</h5>
          <p class="mt-2 text-base font-heading text-gray-500"> Are you sure you want to delete this thread
            (<span class="font-bold">{{ forum.title }}</span>) ?
          </p>
        </div>
        <div class="pt-6 flex gap-4 w-full">
          <secondary-button class="w-full" @click="emits('close')">
            Cancel
          </secondary-button>
          <primary-button class="w-full !bg-secondary" @click="deleteThread">
            Delete
          </primary-button>
        </div>
      </div>
    </template>
  </Modal>
</template>