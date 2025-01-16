<template>
    <header class="absolute sticky bg-white inset-x-0 z-20 top-0">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-12 w-auto" src="/images/UD-logo.svg" alt="" />
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                    @click="mobileMenuOpen = true">
                    <span class="sr-only">Open main menu</span>
                    <MenuIcon class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>
            <div class="hidden items-center lg:flex lg:gap-x-12">
                <a v-for="item in navigation" :key="item.name" :href="item.href"
                    class="text-sm font-semibold leading-6 text-gray-900">{{ item.name }}</a>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center">
                    <primary-button @click="getStarted">
                        Get Started
                    </primary-button>
                </div>
            </div>

        </nav>
        <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-50" />
            <DialogPanel
                class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Upscale</span>
                        <img class="h-8 w-auto" src="/images/UD-logo.svg" alt="" />
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                        <span class="sr-only">Close menu</span>
                        <XIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a v-for="item in navigation" :key="item.name" :href="item.href"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{
                                item.name }}</a>
                        </div>
                    </div>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { Dialog, DialogPanel } from '@headlessui/vue'
import { MenuIcon, XIcon } from '@heroicons/vue/outline'
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"

const navigation = [
    // { name: 'Services', href: '#' },
    { name: 'Home', href: '/' },
    { name: 'Forums', href: '/forums' },
    { name: 'Sign in', href: '/login' },
]

const mobileMenuOpen = ref(false)

function getStarted() {
    router.visit(route('register'))
}

</script>
