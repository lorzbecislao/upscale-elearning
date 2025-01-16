<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import {ref} from "vue"
import EyeIcon from "@/Components/Icon/EyeIcon.vue"
import EyeOffIcon from "@/Components/Icon/EyeOffIcon.vue"
import PasswordChecker from "@/Components/Shared/PasswordChecker.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/Shared/TextInput.vue'

const props = defineProps({
  errors: Object,
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const input_type_1 = ref('password')
const input_type_2 = ref('password')

const contains_alphabet = ref(false)
const contains_eight_characters = ref(false)
const contains_lowercase = ref(false)
const contains_number = ref(false)
const contains_password = ref(false)
const contains_uppercase = ref(false)
const valid_password = ref(false)

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
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Reset Password"/>
  <div class="flex min-h-screen flex-1 mx-auto max-w-7xl">
    <div class="flex flex-1 flex-col justify-center px-4 sm:px-6">
      <div class="w-full">
        <h2 class="mt-4 text-3xl font-bold font-heading text-gray-900">Set a New Password</h2>
        <p class="mt-2 text-sm font-heading">Your previous password has been reset. Please set a new password for your
          account.</p>
        <div class="mt-6">
          <div>
            <form @submit.prevent="submit" class="space-y-6">
              <text-input type="email" autocomplete="username" autofocus v-model="form.email"
                          :errors="form.errors ? form.errors.email : []"
                          label="Email Address" placeholder=""/>

              <!-- Password -->
              <div>
                <label for="password"
                       class="block text-sm font-medium font-heading text-dark-gray-dark6">Create new password</label>
                <div class="relative">
                  <TextInput id="password"
                             v-model="form.password"
                             class="rounded-md border mt-1 block w-full"
                             placeholder="Enter your new password"
                             :required="true"
                             :type="input_type_1"
                             @update:modelValue="checkPassword"/>
                  <div
                      class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <eye-icon v-if="input_type_1 === 'password'"
                              class="w-5 h-5 text-medium-dark" @click="showPassword(1)"/>
                    <eye-off-icon v-else class="w-5 h-5 text-primary"
                                  @click="showPassword(1)"/>
                  </div>
                </div>
                <p v-if="errors && errors.password" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
              </div>

              <password-checker :contains_alphabet="contains_alphabet"
                                :contains_eight_characters="contains_eight_characters"
                                :contains_lowercase="contains_lowercase"
                                :contains_number="contains_number"
                                :contains_password="contains_password"
                                :contains_uppercase="contains_uppercase"/>

              <!-- Confirm Password -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium font-heading text-dark-gray-dark6">Re-enter
                  password</label>
                <div class="relative">
                  <TextInput id="password_confirmation"
                             v-model="form.password_confirmation"
                             class="rounded-md border mt-1 block w-full"
                             placeholder="Re-enter your new password"
                             :required="true"
                             :type="input_type_2"/>
                  <div
                      class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <eye-icon v-if="input_type_2 === 'password'"
                              class="w-5 h-5 text-medium-dark" @click="showPassword(2)"/>
                    <eye-off-icon v-else class="w-5 h-5 text-primary"
                                  @click="showPassword(2)"/>


                  </div>
                </div>
                <p v-if="errors && errors.password" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
              </div>

              <div class="pt-4">
                <primary-button class="w-full" :disabled="!valid_password">
                  Reset Password
                </primary-button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 mt-24 mb-10  flex-1 lg:block">
      <img class="absolute inset-0 h-full object-cover" src="/images/forgot-password.png" alt=""/>
    </div>
  </div>
</template>
