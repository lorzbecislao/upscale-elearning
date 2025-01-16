<script setup>
import Modal from "@/Components/Shared/Modal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue";
import {router} from "@inertiajs/vue3";

const emits = defineEmits(['close'])

const props = defineProps({
  forum: Object,
  open: Boolean
})

function closeThread() {
  router.post(route('admin.forums.close', props.forum.id), null, {
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
          <rect width="60" height="60" rx="30" fill="#FFFBEB"/>
          <g clip-path="url(#clip0_2664_1088)">
            <path d="M30 18.6748C23.7375 18.6748 18.675 23.7373 18.675 29.9998C18.675 36.2623 23.7375 41.3623 30 41.3623C36.2626 41.3623 41.3625 36.2623 41.3625 29.9998C41.3625 23.7373 36.2626 18.6748 30 18.6748ZM30 39.6748C24.675 39.6748 20.3625 35.3248 20.3625 29.9998C20.3625 24.6748 24.675 20.3623 30 20.3623C35.325 20.3623 39.675 24.7123 39.675 30.0373C39.675 35.3248 35.325 39.6748 30 39.6748Z" fill="#FBBF24"/>
            <path d="M30.675 22.5371C29.5875 22.3496 28.4625 22.6496 27.6375 23.3621C26.8125 24.0746 26.325 25.0871 26.325 26.2121C26.325 26.6246 26.4 27.0371 26.55 27.4496C26.7 27.8996 27.1875 28.1246 27.6375 27.9746C28.0875 27.8246 28.3125 27.3371 28.1625 26.8871C28.0875 26.6621 28.05 26.4371 28.05 26.2121C28.05 25.6121 28.3125 25.0496 28.7625 24.6746C29.2125 24.2996 29.8125 24.1121 30.45 24.2246C31.2375 24.3746 31.9125 25.0496 32.0625 25.8371C32.2125 26.7746 31.725 27.7121 30.8625 28.0871C29.8875 28.4996 29.25 29.4746 29.25 30.5996V32.9246C29.25 33.3746 29.625 33.7871 30.1125 33.7871C30.5625 33.7871 30.975 33.4121 30.975 32.9246V30.5996C30.975 30.1871 31.2 29.8121 31.5375 29.6621C33.15 28.9871 34.0875 27.2996 33.7875 25.5746C33.375 24.0371 32.175 22.7996 30.675 22.5371Z" fill="#FBBF24"/>
            <path d="M30.0375 35.1748H29.925C29.475 35.1748 29.0625 35.5498 29.0625 36.0373C29.0625 36.5248 29.4375 36.8998 29.925 36.8998H30.0375C30.4875 36.8998 30.8625 36.5248 30.8625 36.0373C30.8625 35.5498 30.525 35.1748 30.0375 35.1748Z" fill="#FBBF24"/>
          </g>
          <defs>
            <clipPath id="clip0_2664_1088">
              <rect width="24" height="24" fill="white" transform="translate(18 18)"/>
            </clipPath>
          </defs>
        </svg>
        <div class="text-center">
          <h5 class="text-2xl font-semibold font-heading text-gray-900">Close Thread</h5>
          <p class="mt-2 text-base font-heading text-gray-500"> Are you sure you want to close this thread
            (<span class="font-bold">{{ forum.title }}</span>) ?
          </p>
        </div>
        <div class="pt-6 flex gap-4 w-full">
          <secondary-button class="w-full" @click="emits('close')">
            Cancel
          </secondary-button>
          <primary-button class="w-full !bg-[#13C296]" @click="closeThread">
            Close
          </primary-button>
        </div>
      </div>
    </template>
  </Modal>
</template>