<script setup>
import {Head} from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ActivitiesChart from "@/Components/Chart/ActivitiesChart.vue"
import BoxIcon from "@/Components/Icon/BoxIcon.vue"
import CartIcon from "@/Components/Icon/CartIcon.vue"
import MouseIcon from "@/Components/Icon/MouseIcon.vue"
import PieChartIcon from "@/Components/Icon/PieChartIcon.vue"
import UsersIcon from "@/Components/Icon/UsersIcon.vue"
import UsersChart from "@/Components/Chart/UsersChart.vue"
import AcademicCapIcon from "@/Components/Icon/AcademicCapIcon.vue"


// props
const props = defineProps({
    open: Boolean,
    courses: Object,
    numberOfStudents: Object,
    numberOfCompletedStudents: Object,
    newUsers: Number,
    courseCompleted: Number,
    totalUsers: Number,
    activeUsers: Number,
    inactiveUsers: Number,
})

const stats = [
  {
    name: 'New Users',
    date: 'This Week',
    icon: BoxIcon,
    bg: 'bg-secondary',
    iconBg: 'bg-[#13C296]/20',
    iconColor: 'text-secondary',
    count: props.newUsers,
  },
  {
    name: 'Active Users',
    date: 'This Week',
    bg: 'bg-primary',
    iconBg: 'bg-[#1c375b]/20',
    iconColor: 'text-primary',
    icon: UsersIcon,
    count: props.activeUsers,
  },
  {
    name: 'Inactive Users',
    date: 'This Week',
    bg: 'bg-orange',
    iconBg: 'bg-[#f2994a]/20',
    iconColor: 'text-orange',
    icon: MouseIcon,
    count: props.inactiveUsers,
  },
  {
    name: 'Course Completed',
    date: 'This Week',
    bg: 'bg-violet',
    iconBg: 'bg-[#9B51E0]/20',
    iconColor: 'text-violet',
    icon: AcademicCapIcon,
    count: props.courseCompleted,
  }
]


const showPortalBreadcrumb = true
</script>

<template>

    <Head title="Dashboard" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-9">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-4 gap-5">
                    <div v-for="(stat, index) in stats" class="bg-white rounded-md shadow-md">
                        <div class="p-5">
                            <!-- Name and Date -->
                            <div class="inline-flex items-center gap-4">
                                <div class="p-4 rounded-md" :class="stat.iconBg">
                                    <component :is="stat.icon" :class="stat.iconColor" />
                                </div>
                                <div>
                                    <h4 class="font-heading text-base">{{ stat.name }}</h4>
                                    <p class="text-sm text-gray-dark">{{ stat.date }}</p>
                                </div>
                            </div>
                            <!-- Count -->
                            <h1 class="pt-5 font-heading font-bold text-2xl">{{ stat.count }}</h1>
                            <!-- Progress Bar -->
                            <div class="mt-4 overflow-hidden flex-1 h-1.5 text-xs flex rounded bg-gray-300">
                                <div :style="{ width: Math.trunc((stat.count / 1500) * 100) + '%'}" :class="stat.bg"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Charts -->
                <div class="pt-12 grid grid-cols-2 gap-5">
                    <users-chart />
                    <activities-chart />
                </div>
                <!-- Courses -->
                <div class="pt-12">
                    <h4 class="text-2xl font-heading font-semibold">Courses</h4>
                    <div class="pt-4 grid grid-cols-3 gap-4">
                        <div v-for="(course, index) in props.courses" class="bg-white rounded-xl shadow-md">
                            <div class="p-6">
                                <!-- Course name -->
                                <div class="inline-flex items-center gap-6">
                                    <img class="mx-auto w-[50px] h-[50px] rounded-full" :src="course.image_url"
                                        alt="" />
                                    <h4 class="text-2xl font-medium font-heading">{{ course.name }}</h4>
                                </div>
                                <div class="pt-4 flex gap-4 items-center justify-between">
                                    <!-- Progress bar -->
                                    <div class="overflow-hidden flex-1 h-3.5 text-xs flex rounded-full bg-gray-300">
                                        <div :style="{
                        width: (numberOfStudents[course.id] && numberOfStudents[course.id].student_count > 0)
                            ? Math.trunc(
                                (
                                    (numberOfCompletedStudents[course.id]
                                        ? numberOfCompletedStudents[course.id].completed_student_count
                                        : 0
                                    ) / numberOfStudents[course.id].student_count
                                ) * 100
                            ) + '%'
                            : '0'
                    }" class="shadow-none flex flex-col text-center whitespace-nowrap text-xs font-heading bg-primary text-white justify-center">
                                            {{ Math.trunc(
                                            (
                                            (numberOfStudents[course.id] && numberOfStudents[course.id].student_count >
                                            0)
                                            ? (
                                            (numberOfCompletedStudents[course.id]
                                            ? numberOfCompletedStudents[course.id].completed_student_count
                                            : 0
                                            ) / numberOfStudents[course.id].student_count
                                            ) * 100
                                            : 0
                                            )
                                            ) + '%' }}

                                        </div>
                                    </div>
                                    <h4 class="font-semibold font-heading text-xl">{{
                                        numberOfCompletedStudents[course.id] ?
                                        numberOfCompletedStudents[course.id].completed_student_count : 0 }}/{{
                                        numberOfStudents[course.id] ? numberOfStudents[course.id].student_count : 0 }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
    <Teleport v-if="showPortalBreadcrumb" to="#portal-breadcrumb">
        <h4 class="text-2xl font-semibold font-heading">Dashboard</h4>
    </Teleport>
</template>
