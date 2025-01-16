<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import PrimaryButton from "@/Components/Shared/PrimaryButton.vue"
import TextInput from "@/Components/Shared/TextInput.vue"

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
});

function handleBack() {
  window.history.back()
}

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <Head title="Forgot Password"/>
  <div class="flex min-h-screen flex-1 mx-auto max-w-7xl">
    <div class="flex flex-1 flex-col justify-center px-4 sm:px-6">
      <div class="w-full">
        <div class="inline-flex items-center gap-2 cursor-pointer" @click="handleBack">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M16.2375 21.4875C16.0125 21.4875 15.7875 21.4125 15.6375 21.225L7.16255 12.6C6.82505 12.2625 6.82505 11.7375 7.16255 11.4L15.6375 2.77498C15.975 2.43748 16.5 2.43748 16.8375 2.77498C17.175 3.11248 17.175 3.63748 16.8375 3.97498L8.96255 12L16.875 20.025C17.2125 20.3625 17.2125 20.8875 16.875 21.225C16.65 21.375 16.4625 21.4875 16.2375 21.4875Z"
                fill="#111928"/>
          </svg>
          <p class="text-base font-heading">Back To Login</p>
        </div>
        <h2 class="mt-4 text-3xl font-bold font-heading text-gray-900">Forgot your password?</h2>
        <p class="mt-2 text-sm font-heading">Don’t worry, happens to all of us. Enter your email below to recover your
          password.</p>
        <div class="mt-6">
          <div>
            <form @submit.prevent="submit" class="space-y-6">
              <text-input type="email" autocomplete="username" autofocus v-model="form.email"
                          :errors="form.errors ? form.errors.email : []"
                          label="Email Address" placeholder=""/>

              <div class="pt-4">
                <primary-button class="w-full">
                  Send Reset Link
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
