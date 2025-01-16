<script setup>
import {Head, router, usePage} from "@inertiajs/vue3"
import {Calendar} from 'v-calendar'
import 'v-calendar/style.css'
import {ref} from "vue"
import CourseItemCard from "@/Components/Students/CourseItemCard.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import {SearchIcon} from "@heroicons/vue/outline";
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue";

const props = defineProps({
  completed_count: Number,
  ongoing: Array,
  courses: Array
})

const attrs = ref([
  {
    key: 'today',
    highlight: true,
    dates: new Date(),
  },
]);

const showCalendar = ref(true)

const name = usePage().props.auth.user.name

function handleBrowse() {
  router.visit(route('courses'))
}

</script>
<template>
  <student-layout>
    <Head title="Dashboard"/>
    <div class="py-9">
      <div class="max-w-7xl mx-auto">
        <div class="grid gap-4" :class="showCalendar ? 'md:grid-cols-3' : ''">
          <div class="col-span-2">
            <div class="rounded-2xl bg-primary p-10 text-white">
              <h1 class="sm:text-4xl font-heading font-bold ">Hello {{ name }}!</h1>
              <p class="text-lg font-heading">Its good to see you again.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div class="bg-white rounded-xl shadow-md p-3 md:p-10">
                <div class="flex justify-between items-center">
                  <h4 class="text-base md:text-2xl font-heading font-bold">
                    Course in progress
                  </h4>
                  <p class="text-lg md:text-4xl font-heading font-bold">
                    {{ ongoing.length }}
                  </p>
                </div>
                <div v-for="course in ongoing">
                  <div class="mt-2 overflow-hidden flex-1 h-4 text-xs flex rounded-full bg-gray-300">
                    <div
                        :style="{ width: Math.trunc((course.page_number / course.topic_total) * 100) + '%'}"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-xs font-heading bg-primary text-white justify-center">
                      {{ course.name }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-white rounded-xl shadow-md relative">
                <div class="absolute w-full px-6"
                     :class="ongoing.length > 0 ? 'top-1/3' : 'top-1/4'">
                  <div class="md:mt-4 flex justify-between items-center">
                    <h4 class="text-base md:text-2xl font-heading font-bold">
                      Courses Completed
                    </h4>
                    <p class="text-lg md:text-4xl font-heading font-bold">
                      {{ completed_count }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Calendar -->
          <div v-if="showCalendar" class="w-full h-full">
            <Calendar color="primary" :attributes="attrs" expanded>
              <template #footer>
                <div class="grid grid-cols-2 gap-4 px-4 pb-7">
                  <button class="bg-black hover:bg-primary text-white font-bold w-full px-3 py-4 rounded-lg"
                          @click="showCalendar = false">
                    Remove
                  </button>
                  <button class="bg-primary hover:bg-primary-darker text-white font-bold w-full px-3 py-4 rounded-lg"
                          @click="showCalendar = false">
                    Done
                  </button>
                </div>
              </template>
            </Calendar>
          </div>
        </div>

        <!-- Courses taken -->
        <div class="pt-12">
          <h1 class="text-2xl font-heading font-bold">Courses Taken</h1>
          <div>
            <div v-if="courses.length > 0" class="pt-4">
              <course-item-card v-for="course in courses"
                                :course="course"
                                class="mt-4"/>
            </div>
            <div v-else>
              <div class="text-center py-10">

                <search-icon class="mx-auto h-12 w-12 text-primary"/>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No data found</h3>
                <secondary-button @click="handleBrowse" class="mt-2">
                  Browse Courses
                </secondary-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </student-layout>
</template>

<style>
.vc-primary {
  --vc-accent-50: #1c375b;
  --vc-accent-100: #1c375b;
  --vc-accent-200: #1c375b;
  --vc-accent-300: #1c375b;
  --vc-accent-400: #1c375b;
  --vc-accent-500: #1c375b;
  --vc-accent-600: #1c375b;
  --vc-accent-700: #1c375b;
  --vc-accent-800: #1c375b;
  --vc-accent-900: #1c375b;
}
</style>