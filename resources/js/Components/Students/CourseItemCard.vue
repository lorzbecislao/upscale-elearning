<script setup>
import PieChartIcon from "@/Components/Icon/PieChartIcon.vue"
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
  <div class="p-6 bg-[#F9FAFB] flex w-full items-center gap-6 rounded-lg">
    <div class="inline-flex gap-4 items-center">
        <img class="mx-auto w-[50px] h-[50px] rounded-full" :src="course.image" alt="" />
      <h6 class="font-heading text-base">{{ course.name }}</h6>
    </div>
    <!-- Progress bar -->
    <div class="w-full overflow-hidden flex-1 h-3.5 text-xs flex rounded-full bg-gray-300">
      <div
          :style="{ width: Math.trunc((course.page_number / course.topic_total) * 100) + '%'}"
          class="shadow-none flex flex-col text-center whitespace-nowrap text-xs font-heading bg-primary text-white justify-center">
        {{ Math.trunc((course.page_number / course.topic_total) * 100) + '%' }}
      </div>
    </div>
    <!-- date started -->
    <h6 class="text-base text-gray-dark font-heading">Started on: {{ course.created_at }}</h6>
    <!-- Button -->
    <primary-button class="!px-6" @click="handleContinue">
      Continue
    </primary-button>

  </div>
</template>