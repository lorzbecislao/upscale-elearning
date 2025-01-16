<script setup>
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import {router} from "@inertiajs/vue3";

const props = defineProps({
  course: Object
})

function handleContinue() {
  router.visit(props.course.show_route)
}
</script>
<template>
  <div class="flex flex-col items-start justify-between rounded-2xl shadow-xl">
    <div class="relative w-full">
      <div>
        <img v-if="course.image" :src="course.image" alt=""
             class="aspect-[16/9] w-full rounded-t-2xl bg-gray-100 object-scale-down sm:aspect-[2/1] lg:aspect-[3/2]"/>
        <img v-else src="/images/placeholder.jpeg" alt=""
             class="aspect-[16/9] w-full rounded-t-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[2/1]"/>
      </div>
      <div class="absolute inset-0 rounded-t-2xl "/>
    </div>
    <div class="p-6">
      <h1 class="font-heading font-semibold text-xl text-primary">{{ course.name }}</h1>
      <p class="mt-1 line-clamp-2 text-xs font-heading leading-5 text-gray-600">{{ course.description }}</p>

      <!-- Progress bar -->
      <div v-if="course.topic_total" class="w-full overflow-hidden mt-2 flex-1 h-3.5 text-xs flex rounded-full bg-gray-300">
        <div
            :style="{ width: Math.trunc((course.page_number / course.topic_total) * 100) + '%'}"
            class="shadow-none flex flex-col text-center whitespace-nowrap text-xs font-heading bg-primary text-white justify-center">
          {{ Math.trunc((course.page_number / course.topic_total) * 100) + '%' }}
        </div>
      </div>

      <!-- Continue button -->
      
      <primary-button class="mt-8 !py-2 w-full" @click="handleContinue">
        {{ course.completed_at ? 'Finished' : 'Continue' }}
      </primary-button>
    </div>
  </div>
</template>