<template>

    <Head title="Upscale - Elevate your career with web development skills" />
    <div class="bg-white">
        <HeaderSection/>
        <main class="isolate">
            <!-- Hero section -->
            <div class="relative pt-14">
                <div class="py-24 sm:py-32">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                                <span class="text-primary">Elevate</span> your career with <span class="text-primary"> web
                                    development</span>
                                skills
                            </h1>
                            <p class="mt-6 text-lg leading-8 text-gray-600">A full stack educational roadmap made to
                                simplify your path to mastery.</p>
                        </div>
                        <div class="mt-16 flow-root sm:mt-24">
                            <div class="-m-2">
                                <img src="/images/PLMUN.jpeg" alt="App screenshot" width="2432" height="1442"
                                    class="rounded-md shadow-2xl ring-1 ring-gray-900/10" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Courses -->

        <div class="bg-gray-100 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
                <div class="mx-auto max-w-2xl">
                    <h2 class="text-3xl font-bold tracking-tight text-primary sm:text-4xl">Courses</h2>
                    <p class="mt-4 text-lg leading-8 text-gray-dark">Learn everything you need to know</p>
                </div>
                <ul role="list"
                    class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-6 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-8">
                    <li v-for="course in courses" :key="course.name"
                        class="rounded-2xl bg-white px-8 py-10 cursor-pointer hover:shadow-lg"
                        @click="handleCourse(course.id)">
                        <img class="mx-auto h-48 w-48 rounded-full md:h-56 md:w-56" :src="course.image_url" alt="" />
                        <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-primary">{{ course.name }}
                        </h3>
                        <p class="text-sm leading-6 text-gray-400">{{ course.description }}</p>
                        <ul role="list" class="mt-6 flex justify-center gap-x-6">
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <FooterSection/>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import HeaderSection from '@/Components/HeaderSection.vue';
import FooterSection from '@/Components/FooterSection.vue';

defineProps({
    courses: {
        type: Array,
    },
    // canRegister: {
    //     type: Boolean,
    // },
    // laravelVersion: {
    //     type: String,
    //     required: true,
    // },
    // phpVersion: {
    //     type: String,
    //     required: true,
    // },
});

// const courses = [
//   {
//     name: 'HTML',
//     description: 'HTML (HyperText Markup Language) is the most basic building block of the Web',
//     icon: '\/images/html.png',
//   },
//   {
//     name: 'CSS',
//     description: 'Cascading Style Sheets (CSS) is a style sheet language used for specifying the presentation and styling of a document written in a markup language such as HTML or XML (including XML dialects such as SVG, MathML or XHTML)',
//     icon: '\/images/css3.png',
//   },
//   {
//     name: 'JavaScript',
//     description: 'JavaScript is a scripting language that enables you to create dynamically updating content, control multimedia, animate images, and pretty much everything else',
//     icon: '\/images/js.png',
//   },
// ]

function handleCourse(id) {
    router.visit(route('home.topic-list', id));
}

</script>


<style>

</style>
