<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import SecondaryButton from '@/Components/Shared/SecondaryButton.vue';
import { ref, computed, watch } from 'vue';
import HeaderSection from '@/Components/HeaderSection.vue';
import FooterSection from '@/Components/FooterSection.vue';

const props = defineProps({
    assessment: Object,
    question: Object,
    course_id: Number,
    nextQuestion: Object,
    isLastQuestion: {
        type: Boolean,
        default: false
    }
})

const next = () => {
    form.question_id = props.question.id
    form.isLastQuestion = props.isLastQuestion
    form.post(route('home.assessments.next', props.assessment.id), {
        onSuccess: () => {
            form.answer = null
        },
    });
};

function takeLater() {
    router.get(route('home.topic-list', props.course_id))
}



function finish() {
    form.post(route('home.assessments.result', props.assessment.id), {
        onSuccess: () => {
            form.answer = null
        },
    });
}

function handleChangeType(id) {
    form.answer = id;
}

const form = useForm({
    answer: null,
    question_id: props.question ? props.question.id : null,
    assessment_id: props.assessment ? props.assessment.id : null,
    isLastQuestion: props.isLastQuestion
});


</script>

<template>

    <Head title="Upscale - Elevate your career with web development skills" />
    <HeaderSection />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="next">
                <div class="px-4 bg-white overflow-hidden pb-4">
                    <!-- <p class="text-sm text-red-error mb-6">Note: Avoid refreshing the page</p> -->
                    <span class="text-xl">Question:</span>
                    <p class="mt-3 px-4 text-xl text-primary font-bold">{{ question.question }}</p>

                    <!-- First Grid: Options A and B -->
                    <div class="px-4 grid grid-cols-2">
                        <div class="flex flex-col mt-3">
                            <div class="inline-flex items-center">
                                <input :id="question.option_a" @input="handleChangeType(1)" name="options-radio"
                                    type="radio" v-model="form.answer" :value="1"
                                    class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                    :required="true" />
                                <label :for="question.option_a" class="mx-3 block text-lg font-medium text-gray-700">{{
                                    question.option_a }}</label>
                            </div>
                            <div class="inline-flex items-center mt-2">
                                <input :id="question.option_b" @input="handleChangeType(2)" name="options-radio"
                                    type="radio" v-model="form.answer" :value="2"
                                    class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                    :required="true" />
                                <label :for="question.option_b" class="mx-3 block text-lg font-medium text-gray-700">{{
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
                                <label :for="question.option_c" class="mx-3 block text-lg font-medium text-gray-700">{{
                                    question.option_c }}</label>
                            </div>
                            <div class="inline-flex items-center mt-2">
                                <input :id="question.option_d" @input="handleChangeType(4)" name="options-radio"
                                    type="radio" v-model="form.answer" :value="4"
                                    class="h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer"
                                    :required="true" />
                                <label :for="question.option_d" class="mx-3 block text-lg font-medium text-gray-700">{{
                                    question.option_d }}</label>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="flex justify-center px-2 mt-8">
                    <secondary-button class="text-gray-dark mr-3 " type="button" @click="takeLater">
                        Take later
                    </secondary-button>
                    <a :href="route('register') ">
                        <PrimaryButton type="button">
                            Sign in to save your progress
                        </PrimaryButton>
                    </a>
                    <secondary-button class="text-gray-dark ml-3 !px-8" type="submit">
                        {{ isLastQuestion ? 'Finish' : 'Next'}}
                    </secondary-button>
                </div>
            </form>
        </div>
    </div>
    <FooterSection />
</template>
