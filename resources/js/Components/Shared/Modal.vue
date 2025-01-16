<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XIcon } from '@heroicons/vue/outline'

const props = defineProps({
    closable: { type: Boolean, default: true },
    open: { type: Boolean, default: false },
    large: { type: Boolean, default: false }
})
</script>
<template>
    <TransitionRoot :show="open" as="template">
        <Dialog as="div" class="relative z-20" @close="$emit('close')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-20 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel :class="large ? 'max-w-4xl w-full' : 'sm:max-w-lg sm:w-full'"
                            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:p-6">
                            <div v-if="closable" class="hidden sm:block absolute top-0 right-0 pt-7 pr-4">
                                <button class="bg-white rounded-md text-gray-400 hover:text-gray-500" type="button"
                                    @click="$emit('close')">
                                    <span class="sr-only">Close</span>
                                    <XIcon aria-hidden="true" class="h-6 w-6" />
                                </button>
                            </div>
                            <div>
                                <slot name="header"></slot>
                                <slot name="content"></slot>
                            </div>
                            <slot name="footer"></slot>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
