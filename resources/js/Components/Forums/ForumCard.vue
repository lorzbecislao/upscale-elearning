<script setup>
import {Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'
import {DotsVerticalIcon} from "@heroicons/vue/solid"
import {StarIcon} from "@heroicons/vue/solid"
import {CheckCircleIcon, ThumbUpIcon} from "@heroicons/vue/outline"
import {Link, router, usePage} from "@inertiajs/vue3"
import {ref} from "vue"
import CloseThreadModal from "@/Components/Modal/CloseThreadModal.vue"
import DeleteThreadModal from "@/Components/Modal/DeleteThreadModal.vue"
import EditForumModal from "@/Components/Modal/EditForumModal.vue"
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"

const props = defineProps({
  courses: Array,
  forum: Object,
  showPage: {type: Boolean, default: false}
})

const closeThreadModalOpen = ref(false)
const deleteThreadModalOpen = ref(false)
const editForumModalOpen = ref(false)


function handleLike() {
  let url = usePage().props.auth.user.user_type === 2 ? 'forums.like' : 'admin.forums.like'
  router.post(route(url, props.forum.id))
}
</script>

<template>
    <div class="bg-white border border-gray-200 rounded-lg shadow-lg py-5">
        <div class="flex space-x-3 px-4">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" :src="forum.user.profile_photo_url" alt="" />
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-primary">
                    {{ forum.user.name }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ forum.created_at }}
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div v-if="!showPage">
                    <div v-if="forum.is_closed"
                        class="flex bg-secondary flex-shrink-0 gap-1 font-medium self-center text-white font-heading text-sm py-2 px-3 rounded-lg">
                        Closed
                        <check-circle-icon class="w-5 h-5 text-white" />
                    </div>
                    <div v-if="forum.is_new && !forum.is_closed"
                        class="flex bg-primary flex-shrink-0 gap-1 font-medium self-center text-white font-heading text-sm py-2 px-3 rounded-lg">
                        New
                        <star-icon class="w-5 h-5 text-white" />
                    </div>
                </div>
                <div
                    v-if="(!forum.is_closed && forum.created_by_id === $page.props.auth.user.id) || $page.props.auth.user.user_type == 1">
                    <Popover class="relative">
                        <PopoverButton class="mt-2">
                            <DotsVerticalIcon class="h-5 w-5 text-[#9CA3AF]" aria-hidden="true" />
                        </PopoverButton>

                        <transition enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                            <PopoverPanel
                                class="absolute left-10 z-10 mt-2 flex w-screen max-w-min -translate-x-full px-4">
                                <div
                                    class="w-64 shrink rounded-xl bg-white font-medium py-2 leading-6 text-gray-900 shadow-lg ring-1 ring-gray-900/5">
                                    <Link
                                        class="px-4 py-2 text-base font-heading text-gray-dark hover:bg-primary hover:text-white block"
                                        :href="$page.props.auth.user.user_type === 2 ?  route('forums.show', forum.id) : route('admin.forums.show', forum.id)">
                                    View
                                    </Link>
                                    <div class="px-4 py-2 text-base font-heading text-gray-dark hover:bg-primary hover:text-white"
                                        @click="editForumModalOpen = true">
                                        Edit
                                    </div>
                                    <div v-if="$page.props.auth.user.user_type === 1"
                                        class="px-4 py-2 text-base font-heading text-gray-dark hover:bg-primary hover:text-white"
                                        @click="closeThreadModalOpen = true">
                                        Close
                                    </div>
                                    <div class="px-4 py-2 text-base font-heading text-gray-dark hover:bg-primary hover:text-white"
                                        @click="deleteThreadModalOpen = true">
                                        Delete
                                    </div>
                                </div>
                            </PopoverPanel>
                        </transition>
                    </Popover>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 mt-4 py-3 px-4 flex flex-shrink-0">
            <div>
                <Link class="text-black text-xl font-inter font-bold"
                    :href="$page.props.auth.user.user_type === 2 ?  route('forums.show', forum.id) : route('admin.forums.show', forum.id)">
                {{ forum.title }}
                </Link>
                <p class="font-inter mt-2 text-base text-gray-dark">{{ forum.question }}</p>
            </div>
        </div>
        <div class="px-4 mt-4 flex justify-between">
            <span
                class="inline-flex items-center rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-300">
                {{ forum.course }}
            </span>
            <div>
                <div v-if="!showPage">
                    <div class="inline-flex items-center mr-5">
                        <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 8.8877C10.275 8.8877 8.88751 10.2752 8.88751 12.0002C8.88751 13.7252 10.275 15.1127 12 15.1127C13.725 15.1127 15.1125 13.7252 15.1125 12.0002C15.1125 10.2752 13.725 8.8877 12 8.8877ZM12 13.4252C11.2125 13.4252 10.575 12.7877 10.575 12.0002C10.575 11.2127 11.2125 10.5752 12 10.5752C12.7875 10.5752 13.425 11.2127 13.425 12.0002C13.425 12.7877 12.7875 13.4252 12 13.4252Z"
                                fill="#637381" />
                            <path
                                d="M22.95 10.6879C20.8125 7.50039 17.85 4.27539 12 4.27539C6.15 4.27539 3.1875 7.50039 1.05 10.6879C0.525 11.4754 0.525 12.5254 1.05 13.3129C3.1875 16.4629 6.15 19.7254 12 19.7254C17.85 19.7254 20.8125 16.4629 22.95 13.3129C23.475 12.4879 23.475 11.4754 22.95 10.6879ZM21.5625 12.3754C18.825 16.3879 16.0875 18.0379 12 18.0379C7.9125 18.0379 5.175 16.3879 2.4375 12.3754C2.2875 12.1504 2.2875 11.8504 2.4375 11.6254C5.175 7.61289 7.9125 5.96289 12 5.96289C16.0875 5.96289 18.825 7.61289 21.5625 11.6254C21.675 11.8504 21.675 12.1504 21.5625 12.3754Z"
                                fill="#637381" />
                        </svg>
                        {{ forum.views }}
                    </div>
                    <div class="inline-flex items-center mx-5">
                        <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 2.96289H3.00001C1.72501 2.96289 0.637512 4.01289 0.637512 5.32539V15.6754C0.637512 16.9504 1.68751 18.0379 3.00001 18.0379H17.5875L20.775 20.6629C21.075 20.8879 21.4125 21.0379 21.7875 21.0379C22.0125 21.0379 22.2375 21.0004 22.4625 20.8879C23.025 20.6254 23.3625 20.1004 23.3625 19.4629V5.32539C23.3625 4.01289 22.275 2.96289 21 2.96289ZM21.675 19.2004L18.45 16.5379C18.3 16.4254 18.1125 16.3504 17.925 16.3504H3.00001C2.62501 16.3504 2.32501 16.0504 2.32501 15.6754V5.32539C2.32501 4.95039 2.62501 4.65039 3.00001 4.65039H21C21.375 4.65039 21.675 4.95039 21.675 5.32539V19.2004Z"
                                fill="#637381" />
                        </svg>
                        {{ forum.comments }}
                    </div>
                    <div class="inline-flex items-center ml-5">
                        <svg class="mr-2 -mt-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.675 8.6248C21 8.0623 20.175 7.76231 19.3125 7.76231H15.75V5.4373C15.75 3.8248 15.2625 2.6248 14.25 1.9123C13.6125 1.4623 12.8625 1.2373 11.9625 1.2373C11.1375 1.2373 10.5375 1.4248 10.5375 1.4248C9.97499 1.5748 9.59999 2.1373 9.59999 2.6998V6.2623C9.59999 7.6873 8.43749 8.5123 7.61249 8.9248C7.49999 8.6248 7.19999 8.39981 6.82499 8.39981H2.99999C1.91249 8.39981 1.04999 9.2998 1.04999 10.3498V20.8873C1.04999 21.9748 1.94999 22.8373 2.99999 22.8373H6.82499C7.16249 22.8373 7.46249 22.6123 7.61249 22.3498C8.02499 22.4998 8.47499 22.6123 8.92499 22.6123H17.625C19.9875 22.6123 21.5625 21.2998 21.825 19.1248L22.95 12.1498C23.1375 10.7998 22.65 9.4873 21.675 8.6248ZM5.99999 21.1123H2.99999C2.84999 21.1123 2.69999 20.9998 2.69999 20.8123V10.3123C2.69999 10.1623 2.81249 10.0123 2.99999 10.0123H5.99999V21.1123ZM21.2625 11.8123L20.1375 18.8248C19.9125 20.5123 18.6375 20.8498 17.625 20.8498H8.92499C8.47499 20.8498 8.06249 20.6998 7.68749 20.3998V10.7248C9.18749 10.1623 11.2875 8.7373 11.2875 6.2623V2.9623C11.4375 2.9248 11.7 2.8873 11.9625 2.8873C12.4875 2.8873 12.9 2.9998 13.2375 3.2623C13.7625 3.6748 14.0625 4.3873 14.0625 5.4373V7.9123C14.0625 8.77481 14.7375 9.44981 15.6 9.44981H19.3125C19.7625 9.44981 20.2125 9.63731 20.5875 9.93731C21.1125 10.3873 21.375 11.0998 21.2625 11.8123Z"
                                fill="#637381" />
                        </svg>
                        {{ forum.likes }}
                    </div>
                </div>
                <div v-else>
                    <primary-button v-if="!forum.is_like && !forum.is_closed"
                        class="!bg-[#3758F9] !rounded-full !text-white" @click="handleLike">
                        <thumb-up-icon class="w-6 h-6" />
                        Like
                    </primary-button>
                </div>
            </div>
        </div>
        <close-thread-modal :forum="forum" :open="closeThreadModalOpen" @close="closeThreadModalOpen = false" />

        <delete-thread-modal :forum="forum" :open="deleteThreadModalOpen" @close="deleteThreadModalOpen = false" />

        <edit-forum-modal :courses="courses" :forum="forum" :open="editForumModalOpen"
            @close="editForumModalOpen = false" />
    </div>
</template>