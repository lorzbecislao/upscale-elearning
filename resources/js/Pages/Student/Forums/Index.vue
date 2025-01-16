<script setup>
import {Head} from "@inertiajs/vue3"
import {PlusCircleIcon, SearchCircleIcon} from "@heroicons/vue/outline"
import {computed, ref} from "vue"
import CreateForumModal from "@/Components/Modal/CreateForumModal.vue"
import CheckmarkCircleIcon from "@/Components/Icon/CheckmarkCircleIcon.vue"
import ClockIcon from "@/Components/Icon/ClockIcon.vue"
import ForumCard from "@/Components/Forums/ForumCard.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"

const props = defineProps({
  courses: Array,
  closedForums: Array,
  forums: Array,
})

const activeTab = ref('new')

const modalOpen = ref(false)

const forumData = computed(() => {
  return activeTab.value === 'new' ? props.forums : props.closedForums
})
</script>
<template>
    <student-layout>

        <Head title="Forums" />
        <div class="py-9">
            <div class="max-w-7xl mx-auto">
                <!-- Filter -->
                <div class="flex gap-6 items-center">
                    <primary-button class="!rounded-full" :class="activeTab === 'new' ? 'opacity-100' : 'opacity-50'"
                        @click="activeTab = 'new'">
                        <clock-icon class="text-white" />
                        New
                    </primary-button>
                    <primary-button class="!rounded-full" :class="activeTab === 'closed' ? 'opacity-100' : 'opacity-50'"
                        @click="activeTab = 'closed'">
                        <checkmark-circle-icon />
                        Closed
                    </primary-button>
                </div>
                <!-- Create Forum -->
                <div v-if="$page.props.auth.user.forum_full_access == true" class="py-6">
                    <div class="p-6 flex items-center gap-4 bg-white rounded-xl shadow-md border">
                        <img class="inline-block h-14 w-14 rounded-full" :src="$page.props.auth.user.profile_photo_url"
                            alt="" />
                        <div class="flex-1 border border-primary rounded-full p-3 text-gray-500 text-sm font-heading cursor-pointer"
                            @click="modalOpen = true">
                            Create new forum?
                        </div>
                        <primary-button @click="modalOpen = true">
                            <plus-circle-icon class="w-5 h-5" />
                            Create post
                        </primary-button>
                    </div>
                </div>
                <div>
                    <div v-if="forumData.length > 0">
                        <ForumCard v-for="(forum, index) in forumData" class="mt-6" :courses="courses" :key="index"
                            :forum="forum" />
                    </div>
                    <div v-else class="text-center mt-20">
                        <search-circle-icon class="text-gray-900 w-10 h-10 mx-auto" />
                        <h3 class="mt-2 font-semibold font-inter text-sm text-gray-900">No post found!</h3>
                    </div>
                </div>
            </div>
        </div>
        <create-forum-modal :courses="courses" :open="modalOpen" @close="modalOpen = false" />
    </student-layout>
</template>