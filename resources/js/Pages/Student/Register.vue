<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3'
import {ref} from "vue"
import EyeOffIcon from "@/Components/Icon/EyeOffIcon.vue"
import EyeIcon from "@/Components/Icon/EyeIcon.vue"
import PasswordChecker from "@/Components/Shared/PasswordChecker.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SelectInput from "@/Components/Shared/SelectInput.vue"
import TextInput from '@/Components/Shared/TextInput.vue'
import HeaderSection from '@/Components/HeaderSection.vue';
import FooterSection from '@/Components/FooterSection.vue';

const props = defineProps({
  colleges: Array,
  errors: Object,
  programs: Array
})

const form = useForm({
  first_name: null,
  last_name: null,
  student_number: null,
  college: null,
  program: null,
  email: null,
  password: '',
  password_confirmation: '',
  user_type: 2, // Student
});

const contains_alphabet = ref(false)
const contains_eight_characters = ref(false)
const contains_lowercase = ref(false)
const contains_number = ref(false)
const contains_password = ref(false)
const contains_uppercase = ref(false)
const valid_password = ref(false)

const input_type_1 = ref('password')
const input_type_2 = ref('password')

function checkPassword() {
  contains_password.value = form.password !== null && form.password !== '';
  contains_eight_characters.value = /^(?=.{8,})/.test(form.password);
  contains_alphabet.value = /[a-z]/i.test(form.password);
  contains_number.value = /^(?=.*[0-9])/.test(form.password);
  contains_lowercase.value = /^(?=.*[a-z])/.test(form.password);
  contains_uppercase.value = /^(?=.*[A-Z])/.test(form.password);

  valid_password.value = contains_password.value === true &&
      contains_eight_characters.value === true &&
      contains_alphabet.value === true &&
      contains_number.value === true &&
      contains_lowercase.value === true &&
      contains_uppercase.value === true;
}

function showPassword(id) {
  if (id === 1) {
    if (input_type_1.value === 'password') {
      input_type_1.value = 'text';
    } else {
      input_type_1.value = 'password';
    }
  } else {
    if (input_type_2.value === 'password') {
      input_type_2.value = 'text';
    } else {
      input_type_2.value = 'password';
    }
  }
}

const submit = () => {
  form.post(route('signup'));
};
</script>


<template>

    <Head title="Registration" />
    <div class="bg-white">
        <HeaderSection />
        <div class="flex min-h-screen flex-1 mx-auto max-w-7xl">
            <div class="relative hidden w-0 mt-24 mb-10  flex-1 lg:block">
                <img class="absolute inset-0 h-full object-cover" src="/images/register.png" alt="" />
            </div>
            <div class="flex flex-1 flex-col justify-center px-4 sm:px-6">
                <div class="w-full">
                    <h2 class="text-2xl font-bold font-heading leading-9 tracking-tight text-gray-900">User Sign Up</h2>
                    <div class="mt-10">
                        <div>
                            <form @submit.prevent="submit" class="space-y-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <text-input v-model="form.first_name" :errors="errors ? errors.first_name : []"
                                        label="First Name" :required="true" />
                                    <text-input v-model="form.last_name" :errors="errors ? errors.last_name : []"
                                        label="Last Name" :required="true" />
                                </div>
                                <!-- Student Number -->
                                <div>
                                    <text-input v-model="form.student_number"
                                        :errors="errors ? errors.student_number : []" label="Student Number"
                                        :required="true" />
                                </div>

                                <div>
                                    <select-input id="select-program" label="Program" v-model="form.program"
                                        :value="form.program" :required="true">
                                        <option v-for="(program, index) in programs" :key="index" :value=program.value>
                                            {{ program.label }}
                                        </option>
                                        <p v-if="errors && errors.program" class="mt-2 text-sm text-red-600">{{
                                errors.program[0] }}</p>
                                    </select-input>
                                </div>
                                <!-- Email -->
                                <div>
                                    <text-input type="email" v-model="form.email" :errors="errors ? errors.email : []"
                                        label="Email Address" :required="true" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium font-heading text-dark-gray-dark6">Password</label>
                                    <div class="relative">
                                        <TextInput id="password" v-model="form.password"
                                            class="rounded-md border mt-1 block w-full" :required="true"
                                            :type="input_type_1" @update:modelValue="checkPassword" />
                                        <div
                                            class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                            <eye-icon v-if="input_type_1 === 'password'"
                                                class="w-5 h-5 text-medium-dark" @click="showPassword(1)" />
                                            <eye-off-icon v-else class="w-5 h-5 text-primary"
                                                @click="showPassword(1)" />
                                        </div>
                                    </div>
                                    <p v-if="errors && errors.password" class="mt-2 text-sm text-red-600">{{
                                errors.password[0] }}</p>
                                </div>

                                <password-checker :contains_alphabet="contains_alphabet"
                                    :contains_eight_characters="contains_eight_characters"
                                    :contains_lowercase="contains_lowercase" :contains_number="contains_number"
                                    :contains_password="contains_password" :contains_uppercase="contains_uppercase" />

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium font-heading text-dark-gray-dark6">Confirm
                                        Password</label>
                                    <div class="relative">
                                        <TextInput id="password_confirmation" v-model="form.password_confirmation"
                                            class="rounded-md border mt-1 block w-full" :required="true"
                                            :type="input_type_2" />
                                        <div
                                            class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                            <eye-icon v-if="input_type_2 === 'password'"
                                                class="w-5 h-5 text-medium-dark" @click="showPassword(2)" />
                                            <eye-off-icon v-else class="w-5 h-5 text-primary"
                                                @click="showPassword(2)" />


                                        </div>
                                    </div>
                                    <p v-if="errors && errors.password" class="mt-2 text-sm text-red-600">{{
                                errors.password[0] }}</p>
                                </div>
                                <div>
                                    <primary-button class="w-full" :disabled="!valid_password">
                                        Create account
                                    </primary-button>
                                </div>
                                <div class="text-center font-heading font-semibold text-sm">
                                    Already have an account?
                                    <Link :href="route('login')"
                                        class="font-heading font-semibold text-primary text-sm">
                                    Login
                                    </Link>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <FooterSection />
    </div>
</template>
