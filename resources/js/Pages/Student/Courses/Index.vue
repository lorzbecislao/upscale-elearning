<script setup>
import {onMounted, ref, watch} from "vue"
import {Head, router} from "@inertiajs/vue3"
import {SearchIcon} from "@heroicons/vue/outline"
import Pagination from "@/Components/Shared/Pagination.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import SearchInput from "@/Components/Shared/SearchInput.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"

const courses = ref([]);
const search = ref(null);
const sortColumn = ref('id');
const sortDirection = ref('asc');

function loadData(page = 1) {
  axios.get(`/datatables/courses`, {
    params: {
        page: page,
        search: search.value,
        sort_column: sortColumn.value,
          sort_direction: sortDirection.value,
        status: 1
    }
  })
      .then(response => {
        courses.value = response.data;
      })
      .catch(error => {
        console.error(error);
      });
};

function handleSearch(text) {
  search.value = text
  loadData(1)
}

watch([search, sortColumn, sortDirection], () => {
  loadData();
}, {immediate: true});

function handlePage(url) {
  if (url) {
    // Extracting the page number from the URL
    const pageMatch = url.match(/page=(\d+)/);
    const page = pageMatch ? pageMatch[1] : 1;

    // Adding search to the URL if there is a search value
    loadData(page)
  }
}

function handleSpecificPage(page) {
  loadData(page)
}


function handleView(data) {
  router.visit(route('courses.show', data.slug))
}

onMounted(() => {
  loadData();
})

</script>
<template>
  <student-layout>
    <Head title="Courses"/>
    <!-- Search -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto">
        <div class="flex">
          <search-input v-model="search"
                        class="flex-1"
                        placeholder="Search"
                        @update:modelValue="handleSearch($event)"
                        size="large"/>
        </div>

        <!-- Courses -->
        <div>
          <div v-if="courses.data && courses.data.length > 0" class="mt-8 grid grid-cols-1 gap-x-8 gap-y-4 lg:mx-0 lg:max-w-none lg:grid-cols-5">
            <div v-for="(course, index) in courses.data" :key="index">
              <div class="flex flex-col items-start justify-between rounded-2xl shadow-xl h-full">
                <div class="relative w-full">
                  <div>
                    <img v-if="course.image_url" :src="course.image_url" alt=""
                         class="aspect-[16/9] w-full rounded-t-2xl bg-gray-100 object-scale-down sm:aspect-[2/1] lg:aspect-[3/2]"/>
                    <img v-else src="/images/placeholder.jpeg" alt=""
                         class="aspect-[16/9] w-full rounded-t-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[2/1]"/>
                  </div>
                  <div class="absolute inset-0 rounded-t-2xl "/>
                </div>
                <div class="p-4">
                  <h1 class="font-heading font-semibold text-xl text-primary">{{ course.name }}</h1>
                  <p class="mt-1 line-clamp-2 text-xs font-heading leading-5 text-gray-600">{{ course.description }}</p>

                  <!-- View Button -->
                  <primary-button class="w-full mt-4" @click="handleView(course)">
                    View
                  </primary-button>
                </div>
              </div>
            </div>
          </div>

          <!-- No result -->
          <div v-else>
            <div class="text-center py-10">
              <search-icon class="mx-auto h-12 w-12 text-primary"/>
              <h3 class="mt-2 text-sm font-semibold text-gray-900">No data found</h3>
            </div>
          </div>
        </div>
        <Pagination class="mt-8 px-2"
                    :current_page="courses.current_page"
                    :last_page="courses.last_page"
                    :next_page_url="courses.next_page_url"
                    :prev_page_url="courses.prev_page_url"
                    :path="courses.path"
                    :pagination="courses"
                    :search="search"
                    :sort_column="sortColumn"
                    :sort_direction="sortDirection"
                    @emit-page="handlePage"
                    @emit-specific-page="handleSpecificPage"
                    :total_pages="courses.total"
        />
      </div>
    </div>

  </student-layout>
</template>