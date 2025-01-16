<script setup>
import {computed, onMounted, ref} from 'vue'
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  CogIcon,
  DocumentTextIcon,
  InformationCircleIcon,
  LogoutIcon,
  MenuAlt2Icon,
  UsersIcon,
  XIcon,
  CheckCircleIcon
} from '@heroicons/vue/outline'
import {ChevronRightIcon} from "@heroicons/vue/solid"
import {usePage, Link} from "@inertiajs/vue3"
import CaretIcon from "@/Components/Icon/CaretIcon.vue"
import DashboardIcon from "@/Components/Icon/DashboardIcon.vue"
import AcademicCapIcon from "@/Components/Icon/AcademicCapIcon.vue"
import UpscaleLogo from "@/Components/Icon/UpscaleLogo.vue"
import LawBookIcon from "@/Components/Icon/LawBookIcon.vue"
import GraphIcon from "@/Components/Icon/GraphIcon.vue"
import FlashNotifications from "@/Components/Shared/FlashNotifications.vue"

// Computed
const email = computed(() => usePage().props.auth.user.email)
const name = computed(() => usePage().props.auth.user.name)

const navigation = [
    {name: 'Dashboard', route: 'admin.dashboard', url: '/admin/dashboard', icon: 'dashboard-icon'},
    {
        name: 'Users', icon: 'users-icon', url: 'users',
        subMenu: [
            {
                name: 'Admin',
                route: 'admin.users',
                url: '/admin/users/administrators',
            },
            {
                name: 'Students',
                route: 'admin.students',
                url: '/admin/users/students',
            },
        ]
    },
    {name: 'Courses', route: 'admin.courses',  url: '/admin/courses', icon: 'academic-cap-icon'},
    {name: 'Assessments', route: 'admin.assessments', url: '/admin/assessments', icon: 'law-book-icon'},
    {name: 'Forums', route: 'admin.forums', url: '/admin/forums', icon: 'information-circle-icon' },
    {name: 'Reports', route: 'admin.reports', url: '/admin/reports', icon: 'graph-icon' },
]

const sidebarOpen = ref(false)

function getIconComponent(icon) {
  switch (icon) {
    case 'dashboard-icon':
      return DashboardIcon;
    case 'users-icon':
      return UsersIcon;
    case 'academic-cap-icon':
      return AcademicCapIcon;
    case 'cog-icon':
      return CogIcon;
    case 'information-circle-icon':
      return InformationCircleIcon;
    case 'document-text-icon':
      return DocumentTextIcon;
    case 'check-circle-icon':
      return CheckCircleIcon;
    case 'law-book-icon':
      return LawBookIcon;
    case 'graph-icon':
      return GraphIcon;
    default:
      return null; // Return a default component or handle missing icons
  }
}

function isOpen(url) {
  return usePage().url.includes(url)
}

</script>
<template>
  <div class="min-h-screen">
    <TransitionRoot :show="sidebarOpen" as="template">
      <Dialog as="div" class="relative z-40 md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                         enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                         leave-from="opacity-100"
                         leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
        </TransitionChild>

        <div class="fixed inset-0 flex z-40">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                           enter-from="-translate-x-full" enter-to="translate-x-0"
                           leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                           leave-to="-translate-x-full">
            <DialogPanel class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-lightest-gray">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                               enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                               leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                  <button
                      class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                      type="button" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XIcon aria-hidden="true" class="h-6 w-6 text-white"/>
                  </button>
                </div>
              </TransitionChild>
              <div class="flex-shrink-0 flex items-center px-4">
                <!-- logo here  -->
                <upscale-logo/>
              </div>
              <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2 space-y-1">
                  <div v-for="item in navigation" :key="item.name">
                    <div>
                      <Link v-if="!item.subMenu"
                            class="group flex items-center p-2 font-medium font-heading rounded-md"
                            :class="[$page.url.startsWith(item.url) ? 'bg-gradient-to-r from-primary to-innovation text-white text-base' : 'text-sm text-dark-gray-dark hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-innovation', item.name === 'Dashboard' ? 'mb-4' : '', item.name === 'Settings' ? 'mt-4 !text-base' : '', item.name === 'Help Center' ? '!text-base' : '']"
                            :href="route(item.route)">
                        <component aria-hidden="true" class="mr-3 flex-shrink-0 h-6 w-6"
                                   :is="getIconComponent(item.icon)"/>
                        {{ item.name }}
                      </Link>
                      <Disclosure as="div" v-else :defaultOpen="isOpen(item.url)">
                        <template v-slot="{ open }">
                          <DisclosureButton
                              class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-dark-gray-dark">
                            <component :is="getIconComponent(item.icon)"
                                       class="h-6 w-6 shrink-0" aria-hidden="true"/>
                            {{ item.name }}
                            <caret-icon aria-hidden="true"
                                        :class="[open ? 'rotate-90' : '', 'text-dark-gray-dark ml-auto h-5 w-5 shrink-0']"/>
                          </DisclosureButton>
                          <DisclosurePanel as="ul" class="mt-1 px-2">
                            <li v-for="subItem in item.subMenu" :key="subItem.name">
                              <Link
                                  :class="[$page.url.startsWith(item.url) ? 'bg-gradient-to-r from-primary to-innovation text-white text-base' : 'text-sm text-dark-gray-dark hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-innovation', 'group flex items-center px-2 py-2  pl-9 font-medium font-heading rounded-md']"
                                  :href="route(subItem.route)">
                                {{ subItem.name }}
                              </Link>
                            </li>
                          </DisclosurePanel>
                        </template>
                      </Disclosure>
                    </div>
                  </div>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
          <div aria-hidden="true" class="flex-shrink-0 w-14">
          </div>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow pt-5 border-r border-gray-200 bg-lightest-gray overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
          <upscale-logo/>
        </div>
        <div class="mt-5 flex-1 flex flex-col">
          <nav class="flex-1 px-2 space-y-1">
            <div v-for="item in navigation" :key="item.name">
              <div>
                <Link v-if="!item.subMenu"
                      class="group flex items-center p-2 font-medium font-heading rounded-md"
                      :class="[$page.url.startsWith(item.url) ? 'bg-gradient-to-r from-primary to-innovation text-white text-base' : 'text-sm text-dark-gray-dark hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-innovation', item.name === 'Dashboard' ? 'mb-4' : '', item.name === 'Settings' ? 'mt-4 !text-base' : '', item.name === 'Help Center' ? '!text-base' : '']"
                      :href="route(item.route)">
                  <component aria-hidden="true" class="mr-3 flex-shrink-0 h-6 w-6"
                             :is="getIconComponent(item.icon)"/>
                  {{ item.name }}
                </Link>
                <Disclosure as="div" v-else :defaultOpen="isOpen(item.url)">
                  <template v-slot="{ open }">
                    <DisclosureButton
                        :class="[$page.url.includes(item.url) ? 'bg-gradient-to-r from-primary to-innovation text-white text-base' : 'text-sm text-dark-gray-dark hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-innovation']"
                        class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-dark-gray-dark">
                      <component aria-hidden="true" class="h-6 w-6 shrink-0"
                                 :is="getIconComponent(item.icon)"/>
                      {{ item.name }}
                      <caret-icon aria-hidden="true"
                                  :class="[open ? 'rotate-90' : '', 'text-dark-gray-dark ml-auto h-5 w-5 shrink-0', $page.url.includes(item.url) ? 'text-primary' : 'text-dark-gray-dark']"/>
                    </DisclosureButton>
                    <DisclosurePanel as="ul" class="mt-1">
                      <li v-for="subItem in item.subMenu" :key="subItem.name">
                        <Link
                            :class="[$page.url.startsWith(subItem.url) ? 'bg-light-gray from-primary to-innovation text-primary text-base' : 'text-sm text-dark-gray-dark hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-innovation', 'group flex items-center px-6 py-3 font-medium font-heading rounded-md']"
                            :href="route(subItem.route)">
                          {{ subItem.name }}
                        </Link>
                      </li>
                    </DisclosurePanel>
                  </template>
                </Disclosure>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>

    <div class="md:pl-64">
      <div class="max-w-7xl px-6 mx-auto flex flex-col flex-1 min-h-screen">
        <div class="sticky top-0 z-10 flex-shrink-0 bg-white px-4 md:px-0 flex h-16">
          <button
              class="px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary md:hidden"
              @click="sidebarOpen = true" type="button">
            <span class="sr-only">Open sidebar</span>
            <MenuAlt2Icon aria-hidden="true" class="h-6 w-6"/>
          </button>
          <div class="flex-1 flex items-center justify-between"
               :class="$page.url.startsWith('/listings') ? '' : 'md:border-b md:border-gray-300'">
            <div class="flex-1 flex">
              <div id="portal-breadcrumb" class="hidden md:block"></div>
            </div>
            <div class="ml-4 flex items-center md:ml-6">
              <!-- <button
                  class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <span class="sr-only">View notifications</span>
                  <BellIcon aria-hidden="true" class="h-6 w-6" />
              </button> -->

              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton
                      class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Open user menu</span>
                    <img alt="" class="h-8 w-8 rounded-full"
                         :src="$page.props.auth.user.profile_photo_url"/>
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                  <MenuItems
                      class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div
                        class="rounded-t-md bg-gradient-to-r from-responsibility to-integrity text-primary">
                      <div class="p-6">
                        <p class="text-xs">My Account</p>
                        <p class="text-sm font-bold mt-2">{{ name }}</p>
                        <p class="text-sm">{{ email }}</p>
                      </div>
                    </div>
                    <MenuItem>
                      <div class="flex items-center px-6 py-4">
                        <users-icon class="w-5 h-5 text-primary mr-2.5"/>
                        <Link class="block text-sm text-gray-700" :href="route('profile.edit')">
                          Profile
                        </Link>
                      </div>
                    </MenuItem>
                    <MenuItem>
                      <div class="flex items-center px-6 pb-4">
                        <logout-icon class="w-5 h-5 text-primary mr-2.5"/>
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
          </div>
        </div>

        <div class="shadow-lg">
          <div id="portal-banner"></div>
        </div>

        <main>
            <slot/>
            <flash-notifications/>
        </main>

      </div>
    </div>
    <div class="md:pl-64 sticky bottom-0">
      <div class="bg-white" style="box-shadow: 0 0 15px rgba(136, 152, 170, 0.15);">
        <footer id="footer" class="max-w-7xl mx-auto"></footer>
      </div>
    </div>
  </div>
</template>