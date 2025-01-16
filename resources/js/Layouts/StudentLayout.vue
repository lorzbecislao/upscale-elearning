<script setup>
import {computed, ref} from 'vue'
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from '@headlessui/vue'
import {
  LogoutIcon,
  CogIcon,
  UsersIcon,
  XIcon,
  MenuIcon
} from '@heroicons/vue/outline'
import {usePage, Link} from "@inertiajs/vue3"
import FlashNotifications from "@/Components/Shared/FlashNotifications.vue"
import UpscaleLogo from "@/Components/Icon/UpscaleLogo.vue"

// Computed
const email = computed(() => usePage().props.auth.user.email)
const name = computed(() => usePage().props.auth.user.name)

const navigations = [
  {name: 'Dashboard', route: 'dashboard', url: '/dashboard', icon: 'dashboard-icon'},
  {name: 'My Courses', route: 'studentCourses', url: '/my-courses', icon: 'academic-cap-icon'},
  {name: 'Forums', route: 'forums', url: '/forums', icon: 'information-circle-icon'},
  {name: 'Explore', route: 'courses', url: '/explore-courses', icon: 'magnifier'},
]
</script>
<template>
    <div class="min-h-screen">

        <Disclosure as="nav" class="bg-white shadow" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">

                        <div class="flex flex-shrink-0 items-center">
                            <a :href="route('dashboard')">
                                <upscale-logo class="h-8 w-auto" />
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <Link v-for="(item, index) in navigations" :key="index" :href="route(item.route)"
                                :class="[$page.url.startsWith(item.url) ? 'bg-gray-100 text-primary-darker' : 'text-gray-900 hover:bg-gray-50 hover:text-gray-900', 'font-heading inline-flex items-center rounded-md py-2 px-3 text-sm font-medium']">
                            {{ item.name }}
                            </Link>
                        </div>
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative ml-10">
                            <div>
                                <MenuButton
                                    class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                    <span class="absolute -inset-1.5" />
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" :src="$page.props.auth.user.profile_photo_url"
                                        alt="" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-200"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="z-30 origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div
                                        class="rounded-t-md bg-gradient-to-r from-responsibility to-integrity text-primary">
                                        <div class="p-6 font-heading">
                                            <p class="text-xs">My Account</p>
                                            <p class="text-sm font-bold mt-2">{{ name }}</p>
                                            <p class="text-sm">{{ email }}</p>
                                        </div>
                                    </div>
                                    <MenuItem>
                                    <div class="flex items-center px-6 py-4">
                                        <users-icon class="w-5 h-5 text-primary mr-2.5" />
                                        <Link class="block text-sm text-gray-700" :href="route('profile.edit') ">
                                        Profile
                                        </Link>
                                    </div>
                                    </MenuItem>
                                    <MenuItem>
                                    <div class="flex font-heading items-center px-6 pb-4">
                                        <logout-icon class="w-5 h-5 text-primary mr-2.5" />
                                        <Link as="button" class="block text-sm text-gray-700" :href="route('logout')"
                                            method="post" type="button">
                                        Logout
                                        </Link>
                                    </div>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <!-- Mobile view -->
            <DisclosurePanel class="sm:hidden">
                <div class="space-y-1 pb-3 pt-2">
                    <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                    <DisclosureButton v-for="item in navigations" as="a" :href="route(item.route)"
                        class="font-heading block py-2 pl-3 pr-4 text-base font-medium text-primary"
                        :class="$page.url.startsWith(item.url) ? 'bg-gradient-to-r from-primary to-innovation text-white text-base' : ''">
                        {{ item.name }}
                    </DisclosureButton>
                </div>
                <div class="border-t border-gray-200 pb-3 pt-4">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="$page.props.auth.user.profile_photo_url" alt="" />
                        </div>
                        <div class="ml-3 font-heading">
                            <div class="text-base font-medium text-gray-800">{{ name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 font-heading">
                        <DisclosureButton as="button" :href="route('logout')" method="post" type="button"
                            class="block px-4 py-2 text-base font-medium text-primary">
                            Logout
                        </DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <div class="max-w-7xl px-6 mx-auto flex flex-col flex-1 min-h-screen">
            <main>
                <slot />
                <flash-notifications />
            </main>
        </div>
        <div class="md:pl-64 sticky bottom-0">
            <div class="bg-white" style="box-shadow: 0 0 15px rgba(136, 152, 170, 0.15);">
                <footer id="footer" class="max-w-7xl mx-auto"></footer>
            </div>
        </div>

    </div>
</template>