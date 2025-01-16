<script setup>
import {ChevronDoubleUpIcon} from "@heroicons/vue/outline"
import {ref} from "vue"
import ReplyCard from "@/Components/Forums/ReplyCard.vue"
import ReplyDetailsCard from "@/Components/Forums/ReplyDetailsCard.vue";

const props = defineProps({
  comment: Object
})

const showReply = ref(false)

const showReplies = ref(true)
</script>

<template>
    <div>
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg py-5">
            <div class="flex space-x-3 px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" :src="comment.user.profile_photo_url" alt="" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-primary">
                        {{ comment.user.name }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ comment.created_at }}
                    </p>
                </div>

            </div>
            <div class="mt-2">
                <p class="px-4 font-inter mt-2 text-base text-gray-dark">{{ comment.content }}</p>
                <div class="mt-2 border-t border-gray-300">
                    <div class="pt-4 flex justify-end gap-3 px-4">
                        <div v-if="comment.replies.length > 0" class="inline-flex gap-2 items-center cursor-pointer"
                            @click="showReplies = !showReplies">
                            <chevron-double-up-icon class="w-6 h-6 text-[#2D68F8]" />
                            <p class="text-base font-inter font-semibold text-[#2D68F8]"> {{ showReplies ? 'Hide' :
                                'Show' }} all
                                replies</p>
                        </div>
                        <div v-if="$page.props.auth.user.forum_full_access == true"
                            class="inline-flex gap-2 items-center cursor-pointer" @click="showReply = true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.6625 4.7625C5.8875 4.7625 6.1125 4.8375 6.2625 5.025L17.55 16.3125L17.625 7.3125C17.625 6.8625 18 6.45 18.4875 6.4875C18.9375 6.4875 19.3125 6.8625 19.3125 7.35L19.2 18.375C19.2 18.825 18.825 19.2 18.375 19.2L7.3125 19.3125C6.8625 19.3125 6.4875 18.9375 6.4875 18.4875C6.4875 18.0375 6.8625 17.625 7.3125 17.625L16.3875 17.55L5.0625 6.225C4.725 5.8875 4.725 5.3625 5.0625 5.025C5.2125 4.875 5.4375 4.7625 5.6625 4.7625Z"
                                    fill="#2D68F8" />
                            </svg>
                            <p class="text-base font-inter font-semibold text-[#2D68F8]">Reply</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <reply-card v-if="$page.props.auth.user.forum_full_access == true && showReply" class="mt-6 ml-32"
            :comment="comment" @cancel="showReply = false" />

        <div v-if="showReplies">
            <reply-details-card v-for="(reply, index) in comment.replies" :comment="comment" class="mt-6 ml-32"
                :reply="reply" />
        </div>
    </div>
</template>