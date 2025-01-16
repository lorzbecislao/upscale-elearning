<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from "vue"
import Checkbox from '@/Components/Checkbox.vue'
import EyeIcon from "@/Components/Icon/EyeIcon.vue"
import EyeOffIcon from "@/Components/Icon/EyeOffIcon.vue"
import TextInput from "@/Components/Shared/TextInput.vue"

const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const input_type_1 = ref('password')

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function showPassword() {
    if (input_type_1.value === 'password') {
        input_type_1.value = 'text';
    } else {
        input_type_1.value = 'password';
    }
}

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex flex-1 flex-col">
        <div>
            <div class="mx-auto max-w-7xl mt-24 mb-6 flex flex-1 flex-col bg-white rounded-2xl lg:flex-row">
          
                    <Head title="Login" />
                    <div class="items-center m-10">
                        <div class="max-h-fit mx-auto w-full lg:w-96">
                            <!-- Logo -->
                            <div>
                                <img class="mx-auto h-24 w-auto" src="/images/UD-logo.svg" alt="Your Logo" />
                                <h2 class="mb-6 mt-3 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Admin Login</h2>
                            </div>

                            <div class="items-center w-full">
                                <form class="space-y-5" @submit.prevent="submit">
                                    <div class="relative">
                                        <text-input type="email" autocomplete="username" autofocus  v-model="form.email" :errors="form.errors ? form.errors.email : []" 
                                            label="Email Address" placeholder="" />
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-medium font-heading text-dark-gray-dark6">Password</label>
                                        <div class="relative">
                                            <TextInput id="password" v-model="form.password" autocomplete="current-password"
                                                class="rounded-md border  mt-1 block w-full" required
                                                :type="input_type_1" />
                                            <div
                                                class="absolute cursor-pointer inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                                <eye-icon v-if="input_type_1 === 'password'"
                                                    class="w-5 h-5 text-medium-dark" @click="showPassword()" />
                                                <eye-off-icon v-else class="w-5 h-5 text-primary"
                                                    @click="showPassword()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center lg:flex-row lg:justify-between">
                                        <div class="flex items-center relative hidden lg:inline-flex">
                                            <!-- Hide on small screens -->
                                            <Checkbox v-model:checked="form.remember" class="rounded-sm" name="remember" />
                                            <label class="text-sm ml-3 block text-gray-900" for="remember-me">
                                                Remember me
                                            </label>
                                        </div>
                                        <div class="text-sm leading-6">
                                            <Link :href="route('password.request')"
                                                class="font-medium font-[Inter] text-darkest underline lg:mx-auto">
                                            Forgot password?
                                            </Link>
                                        </div>
                                    </div>
                                    <button
                                        class="flex w-full justify-center rounded-full bg-primary px-3 py-4 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-primary-darker focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        type="submit">
                                        Login
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                <div class="relative hidden w-full lg:block object-cover">
                    <div class="w-full h-full">
                        <img alt="" class="inset-0 overflow-hidden w-full object-cover"
                            src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" />
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>
