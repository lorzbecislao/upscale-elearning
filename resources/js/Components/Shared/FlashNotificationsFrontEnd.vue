<script setup>

import { CheckCircleIcon } from "@heroicons/vue/solid"
import { watch } from "vue";
import { onMounted } from "vue";

// emits
const emits = defineEmits(['close', 'toggle-show', 'uploaded'])

// props
const props = defineProps({
    state: Boolean,
    infos: Object,
    icon: { type: String, default: 'check' }
})

// methods
function close() {
    emits('close')
}
function toggleShow() {
    emits('toggle-show')
}

watch(() => props.state,
    () => {
        if (props.state) {
            setTimeout(() => {
                close()
            }, 2000);
        }
    },
    { immediate: true, deep: true }
)

</script>

<template>
    <div aria-live="assertive" class="fixed top-6 z-20 right-12 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="w-full flex flex-col items-end space-y-4">
            <transition enter-active-class="transform ease-out duration-300 transition"
                    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                    leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-if="state" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="p-4" >
                            <div class="flex justify-between">
                                <div class="flex items-start gap-3">
                                    <CheckCircleIcon aria-hidden="true" class="h-6 w-6 text-green-success" />
                                    <div>
                                        <p class="font-medium font-heading text-black-darkest">
                                           {{ infos.header }}
                                        </p>
                                        <p class="font-heading text-dark-gray-dark">
                                            {{ infos.message }}
                                        </p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex">
                                    <button
                                        class="bg-transparent rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
                                        @click="show = false">
                                        <span class="sr-only">Close</span>
                                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                fill-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </transition>
        </div>
    </div>

</template>

