<script setup>
import {computed, ref} from "vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import {Head, router} from "@inertiajs/vue3"
import CourseCard from "@/Components/Courses/CourseCard.vue"
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue"
import {SearchIcon} from "@heroicons/vue/outline";

const props = defineProps({
  courses: Array,
  ongoing: Array,
  completed: Array,
})

const activeTab = ref('All')
const tabs = [
  {
    name: 'All',
    value: null,
    count: props.courses.length
  },
  {
    name: 'Ongoing',
    count: props.ongoing.length
  },
  {
    name: 'Completed',
    count: props.completed.length
  }
]

const activeCourses = computed(() => {
  if(activeTab.value === 'All') {
    return props.courses
  } else if(activeTab.value === 'Ongoing') {
    return props.ongoing
  } else {
    return props.completed
  }
})


function handleBrowse() {
  router.visit(route('courses'))
}

</script>
<template>
  <student-layout>
    <Head title="My Courses"/>
    <div class="py-9">
      <div class="max-w-7xl mx-auto">
        <!-- Filter -->
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs"
                  v-model="activeTab"
                  class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
            <option v-for="tab in tabs" :key="tab.name" :value="tab.name"> {{ tab.name }}</option>
          </select>
        </div>
        <div class="hidden sm:block">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 font-heading" aria-label="Tabs">
              <div v-for="tab in tabs" :key="tab.name"
                   :class="[activeTab === tab.name ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700', 'cursor-pointer flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium']"
                   :aria-current="tab.current ? 'page' : undefined"
                   @click="activeTab =tab.name">
                {{ tab.name }}
                <span v-if="tab.count"
                      :class="[activeTab === tab.name? 'bg-primary text-white' : 'bg-gray-100 text-gray-900', 'ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block']">{{
                    tab.count
                  }}</span>
              </div>
            </nav>
          </div>
        </div>
        <!-- Browse Courses -->
        <div class="mt-6">
          <secondary-button @click="handleBrowse">
            Browse Courses
          </secondary-button>
        </div>
        <div>
          <div v-if="activeCourses.length > 0"
               class="mt-6 grid grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <course-card v-for="course in activeCourses" :course="course"/>
          </div>
          <!-- No result -->
          <div v-else>
            <div class="text-center py-10">
              <search-icon class="mx-auto h-12 w-12 text-primary"/>
              <h3 class="mt-2 text-sm font-semibold text-gray-900">No data found</h3>
            </div>
          </div>
        </div>
      </div>


    </div>
  </student-layout>
</template>