<script setup>
import {ArrowLeftIcon} from "@heroicons/vue/solid"
import {Head, router} from '@inertiajs/vue3'
import ForumCard from "@/Components/Forums/ForumCard.vue"
import CommentCard from "@/Components/Forums/CommentCard.vue"
import CommentDetailsCard from "@/Components/Forums/CommentDetailsCard.vue"
import StudentLayout from "@/Layouts/StudentLayout.vue"

const props = defineProps({
  forum: Object
})

const showPortalBreadcrumb = true

function handleBack() {
  router.visit(route('forums'))
}

</script>
<template>
  <Head title="Forums"/>
  <StudentLayout>
    <div class="py-9">
      <div class="max-w-7xl mx-auto">
        <div class="cursor-pointer inline-flex gap-2" @click="handleBack">
          <arrow-left-icon class="w-6 h-6 text-black"/>
          <p class="text-base font-inter font-semibold text-gray-dark"> Back</p>
        </div>

        <div class="mt-6">
          <forum-card :forum="forum" :show-page="true"/>
          <h3 class="text-3xl font-inter text-center py-6 text-gray-dark font-bold">
            Comments
          </h3>

          <comment-card v-if="!forum.is_closed" :forum="forum"/>

          <div class="mt-6 border-t border-gray-300">
            <comment-details-card v-for="(comment, index) in forum.comments"
                                  class="mt-5"
                                  :key="index"
                                  :comment="comment"/>
          </div>
        </div>
      </div>
    </div>
  </StudentLayout>
</template>