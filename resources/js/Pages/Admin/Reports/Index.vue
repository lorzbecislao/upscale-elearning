<script setup>
import {Head} from '@inertiajs/vue3'
import {ref} from "vue"
import AdminLayout from '@/Layouts/AdminLayout.vue'
import GenerateReportModal from "@/Components/Modal/GenerateReportModal.vue"
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'

defineProps({
    courses: { type: Array, default: () => [] },
    programs: { type: Array, default: () => [] },

});

const modalOpen = ref(false)
const reportType = ref(null)

const reports = [
  {name: 'Students Report', value: 'students'},
  {name: 'Courses Report', value: 'courses'},
]

const showPortalBreadcrumb = true

function handleGenerate(report) {
  modalOpen.value = true
  reportType.value = report.value
}
</script>

<template>

    <Head title="Reports" />
    <AdminLayout>
        <div class="py-9">
            <div class="max-w-7xl mx-auto">
                <template v-for="(report, index) in reports">
                    <div class="border shadow-md rounded-lg border-gray-200 mt-3 bg-white px-4 py-5 sm:px-6">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="inline-flex ml-4 mt-4 items-center">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="25" cy="25" r="25" fill="#F3F4F6" />
                                    <path
                                        d="M20.4625 23.6594H27.0625C27.475 23.6594 27.8531 23.3156 27.8531 22.8687C27.8531 22.4219 27.5094 22.0781 27.0625 22.0781H20.4625C20.05 22.0781 19.6719 22.4219 19.6719 22.8687C19.6719 23.3156 20.0156 23.6594 20.4625 23.6594Z"
                                        fill="#111928" />
                                    <path
                                        d="M20.4625 27.3039H27.0625C27.475 27.3039 27.8531 26.9602 27.8531 26.5133C27.8531 26.0664 27.5094 25.7227 27.0625 25.7227H20.4625C20.05 25.7227 19.6719 26.0664 19.6719 26.5133C19.6719 26.9602 20.0156 27.3039 20.4625 27.3039Z"
                                        fill="#111928" />
                                    <path
                                        d="M29.5375 29.4004H20.4625C20.05 29.4004 19.6719 29.7441 19.6719 30.191C19.6719 30.6379 20.0156 30.9816 20.4625 30.9816H29.5719C29.9844 30.9816 30.3625 30.6379 30.3625 30.191C30.3625 29.7441 29.9844 29.4004 29.5375 29.4004Z"
                                        fill="#111928" />
                                    <path
                                        d="M33.2844 17.816H25.3437L24.6219 16.441C24.2437 15.7535 23.5562 15.3066 22.7656 15.3066H16.7156C15.5469 15.3066 14.6187 16.2348 14.6187 17.4035V32.5973C14.6187 33.766 15.5469 34.6941 16.7156 34.6941H33.3187C34.4875 34.6941 35.4156 33.766 35.4156 32.5973V19.9129C35.4156 18.7441 34.4531 17.816 33.2844 17.816ZM33.8687 32.5973C33.8687 32.9066 33.6281 33.1473 33.3187 33.1473H16.7156C16.4062 33.1473 16.1656 32.9066 16.1656 32.5973V17.4035C16.1656 17.0941 16.4062 16.8535 16.7156 16.8535H22.7656C22.9719 16.8535 23.1437 16.9566 23.2469 17.1629L24.2094 18.9504C24.3469 19.191 24.6219 19.3629 24.8969 19.3629H33.3187C33.6281 19.3629 33.8687 19.6035 33.8687 19.9129V32.5973Z"
                                        fill="#111928" />
                                </svg>
                                <h3 class="ml-3 text-base font-semibold leading-6 text-gray-900">{{ report.name }}</h3>
                            </div>
                            <div class="ml-4 mt-4 flex-shrink-0">
                                <PrimaryButton @click="handleGenerate(report)">
                                    Generate Report
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <generate-report-modal :open="modalOpen" :programs="programs" :type="reportType" @close="modalOpen = false" />
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <h4 class="text-2xl font-semibold font-heading">Reports</h4>
    </Teleport>
</template>
