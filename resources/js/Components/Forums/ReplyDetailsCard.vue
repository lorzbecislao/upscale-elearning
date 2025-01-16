<script setup>
import {ref} from "vue"

const props = defineProps({
  comment: Object,
  reply: Object
})

</script>

<template>
  <div>
    <div class="bg-white border border-gray-200 rounded-lg shadow-lg py-4">
      <div class="flex space-x-3 px-4">
        <div class="flex-shrink-0">
          <img class="h-10 w-10 rounded-full"
               :src="reply.user.profile_photo_url"
               alt=""/>
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-sm font-semibold text-primary">
            {{ reply.user.name }}
          </p>
          <p class="text-sm text-gray-500">
            {{ reply.created_at }}
          </p>
        </div>

      </div>
      <div class="mt-2">
        <p class="px-4 font-inter mt-2 text-base text-gray-dark">{{ reply.content }}</p>
        <div class="mt-2 border-t border-gray-300">
            <p class="px-4 pt-4 font-inter text-sm font-semibold text-gray-dark">Replied to: {{ comment.user.name }}</p>
        </div>
      </div>
    </div>
  </div>
</template>