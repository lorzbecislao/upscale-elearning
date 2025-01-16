<script setup>
import {Head, router, useForm} from "@inertiajs/vue3"
import StudentLayout from "@/Layouts/StudentLayout.vue"
import {ClockIcon} from "@heroicons/vue/outline";
import SecondaryButton from "@/Components/Shared/SecondaryButton.vue";
import {CheckCircleIcon} from "@heroicons/vue/solid";
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue";

const props = defineProps({
  question: Object,
  assessment: Object,
  isLastQuestion: Boolean,
  topic: Object
})

const form = useForm({
  answer: null,
  question_id: props.question ? props.question.id : null,
  assessment_id: props.assessment ? props.assessment.id : null,
  isLastQuestion: props.isLastQuestion
});

const pageTitle = props.assessment.title

function next() {
  form.question_id = props.question.id
  form.isLastQuestion = props.isLastQuestion
  form.post(route('assessment.next', props.assessment.id), {
    onSuccess: () => {
      form.answer = null
    },
  });
}

function handleChangeType(id) {
  form.answer = id;
}

function handleViewCourse() {
  router.visit(props.topic.course.show_route)
}
</script>
<template>
    <student-layout>

        <Head :title="pageTitle" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center pt-6">
                    <div>
                        <img v-if="topic.course.image_url" class="h-48 w-48 md:h-56 md:w-56"
                            :src="topic.course.image_url" alt="" />
                        <img v-else class="h-48 w-48 border object-cover rounded-full " src="/images/placeholder.jpeg"
                            alt="" />
                    </div>
                    <div class="flex-1 ml-3">
                        <p class="mt-2 text-3xl font-heading font-bold tracking-tight text-gray-900 sm:text-4xl">
                            {{ assessment.type === 1 ? 'Practical' : 'Quiz' }}
                        </p>
                        <p class="mt-2 font-heading text-base leading-8 text-gray-600">{{ topic.title }}</p>
                    </div>
                </div>
                <form @submit.prevent="next">
                    <div class="p-4 bg-white overflow-hidden">
                        <!-- <p class="text-sm text-red-error mb-6">Note: Avoid refreshing the page</p> -->
                        <span class="text-xl font-heading">Question:</span>
                        <p class="mt-3 px-4 text-xl text-primary font-bold">{{ question.question }}</p>

                        <!-- First Grid: Options A and B -->
                        <div class="px-4 grid grid-cols-2">
                            <div class="flex flex-col mt-3">
                                <div class="inline-flex items-center">
                                    <input :id="question.option_a" @input="handleChangeType(1)" name="options-radio"
                                        type="radio" v-model="form.answer" :value="1"
                                        class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                        :required="true" />
                                    <label :for="question.option_a"
                                        class="mx-3 block text-lg font-medium text-gray-700">{{
                                        question.option_a }}</label>
                                </div>
                                <div class="inline-flex items-center mt-2">
                                    <input :id="question.option_b" @input="handleChangeType(2)" name="options-radio"
                                        type="radio" v-model="form.answer" :value="2"
                                        class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                        :required="true" />
                                    <label :for="question.option_b"
                                        class="mx-3 block text-lg font-medium text-gray-700">{{
                                        question.option_b }}</label>
                                </div>
                            </div>

                            <!-- Second Grid: Options C and D -->
                            <div class="flex flex-col mt-3">
                                <div class="inline-flex items-center">
                                    <input :id="question.option_c" @input="handleChangeType(3)" name="options-radio"
                                        type="radio" v-model="form.answer" :value="3"
                                        class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                        :required="true" />
                                    <label :for="question.option_c"
                                        class="mx-3 block text-lg font-medium text-gray-700">{{
                                        question.option_c }}</label>
                                </div>
                                <div class="inline-flex items-center mt-2">
                                    <input :id="question.option_d" @input="handleChangeType(4)" name="options-radio"
                                        type="radio" v-model="form.answer" :value="4"
                                        class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                        :required="true" />
                                    <label :for="question.option_d"
                                        class="mx-3 block text-lg font-medium text-gray-700">{{
                                        question.option_d }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="border-t mt-6">
                            <div class="flex justify-center gap-4 px-2 mt-4">
                                <div class="flex justify-center gap-4 px-2 mt-4"></div>
                                <secondary-button class="font-heading text-gray-dark text-sm" type="button"
                                    @click="handleViewCourse">
                                    <clock-icon class="w-5 h-5" />
                                    Take later
                                </secondary-button>
                                <primary-button class="font-heading text-gray-dark text-sm" type="submit">
                                    <check-circle-icon class="w-5 h-5" />
                                    {{ isLastQuestion ? 'Finish' : 'Next'}}
                                </primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </student-layout>
</template>