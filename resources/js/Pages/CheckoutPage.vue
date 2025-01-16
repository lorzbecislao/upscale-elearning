<template>
    <div class="bg-white">
        <Head title="Checkout" />
        <HeaderSection />
        <main>
            <div class="mx-auto max-w-7xl px-6 sm:mt-8 lg:px-8">
                <form @submit.prevent="submitForm" class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                  <div>
                    <div>
                      <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Address</label>
                            <div class="mt-2">
                                <input type="email" v-model="form.email" name="email" required id="email" class="block w-full px-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="you@example.com" />
                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="mt-10 border-t border-gray-200 pt-10">
                      <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                      <fieldset class="mt-4">
                        <legend class="sr-only">Payment type</legend>
                        <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                          <div v-for="(paymentMethod, paymentMethodIdx) in customPaymentMethods" :key="paymentMethod.id" class="flex items-center">
                            <input v-if="paymentMethodIdx === 0" @input="handlePaymentMethodChange(paymentMethod.id)" :id="paymentMethod.id" name="payment-type-radio" type="radio" checked="" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" />
                            <input v-else :id="paymentMethod.id" @input="handlePaymentMethodChange(paymentMethod.id)" name="payment-type-radio" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" />
                            <label :for="paymentMethod.id" class="ml-3 block text-sm font-medium text-gray-700">{{ paymentMethod.title }}</label>
                          </div> 
                        </div>
                      </fieldset>

                       <div v-if="selectedPaymentMethod === 'paypal-radio'" class="mt-4 px-4 py-4 rounded-lg border border-gray-200">
                            <!-- <div id="paypal-button-container" class="paypal-button"></div> -->
                        </div>

                        <div v-else-if="selectedPaymentMethod === 'direct-bank'" class="mt-4 px-4 py-4 rounded-lg border border-gray-200">
                            <span class="text-sm leading-6 text-gray-700">
                                1. Please make the payment by transferring the exact amount mentioned in the total to one of the following bank accounts:
                            </span>
                            <div class="ml-4 mb-3">
                                <dl class="flex flex-wrap">
                                    <div class="flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2">
                                        <dt class="text-sm leading-6 text-gray-900">Bank Account 1</dt>
                                        <dd class="text-sm font-medium leading-6 text-gray-900">125-444-3333</dd>
                                    </div>
                                </dl>
                                <dl class="flex flex-wrap">
                                    <div class="flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2">
                                        <dt class="text-sm leading-6 text-gray-900">Bank Account 2</dt>
                                        <dd class="text-sm font-medium leading-6 text-gray-900">125-444-3333</dd>
                                    </div>
                                </dl>
                                <dl class="flex flex-wrap">
                                    <div class="flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2">
                                        <dt class="text-sm leading-6 text-gray-900">Bank Account 3</dt>
                                        <dd class="text-sm font-medium leading-6 text-gray-900">125-444-3333</dd>
                                    </div>
                                </dl>
                            </div>
                            <span class="text-sm leading-6 text-gray-700">
                                    2. After completing the payment, kindly send a copy of the payment receipt to the following email address as proof of payment:
                            </span>
                            <div class="ml-4 mb-3">
                                <dl class="flex flex-wrap">
                                    <div class="flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2">
                                        <dt class="text-sm leading-6 text-gray-900">Email Address 1</dt>
                                        <dd class="text-sm font-medium leading-6 text-gray-900">email@example.com</dd>
                                    </div>
                                </dl>
                            </div>
                            <span class="text-sm leading-6 text-gray-700">
                                    3. Once you have sent the payment receipt to the provided email address, please allow our team some time to verify the payment. Once the payment has been confirmed, we will notify you via email and send the product directly to your email address. If you have any further questions or need assistance, please feel free to contact us.
                            </span>
                        </div>

                        <div v-else class="mt-4 px-4 py-4 rounded-lg border border-gray-200">
                            <span class="text-sm leading-6 text-gray-700">
                                    1. Please make the payment by transferring the exact amount mentioned in the total to one of the following cryptocurrency wallet address:
                            </span>
                            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">BTC</dt>
                                    <dd class="text-gray-700">
                                        <div class="font-medium text-gray-900">1CzDjB9SL8WKxnzSrZP5TH5BdmdBm7heRB</div>
                                    </dd>
                                </div>
                                <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">USDT</dt>
                                    <dd class="flex items-start gap-x-2">
                                        <div class="font-medium text-gray-900">0x4817a52365836ff30412110ec1a0455234c8377b</div>
                                    </dd>
                                </div>
                                 <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">ETH</dt>
                                    <dd class="flex items-start gap-x-2">
                                        <div class="font-medium text-gray-900">0x4817a52365836ff30412110ec1a0455234c8377b</div>
                                    </dd>
                                </div>
                                 <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">Polygon</dt>
                                    <dd class="flex items-start gap-x-2">
                                        <div class="font-medium text-gray-900">0x4817a52365836ff30412110ec1a0455234c8377b</div>
                                    </dd>
                                </div>
                            </dl>
                            <span class="text-sm leading-6 text-gray-700">
                                    2. After completing the payment, kindly send a copy of the payment receipt to the following email address as proof of payment:
                            </span>
                            <div class="ml-4 mb-3">
                                <dl class="flex flex-wrap">
                                    <div class="flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-2">
                                        <dt class="text-sm leading-6 text-gray-900">Email Address 1</dt>
                                        <dd class="text-sm font-medium leading-6 text-gray-900">email@example.com</dd>
                                    </div>
                                </dl>
                            </div>
                            <span class="text-sm leading-6 text-gray-700">
                                    3. Once you have sent the payment receipt to the provided email address, please allow our team some time to verify the payment. Once the payment has been confirmed, we will notify you via email and send the product directly to your email address. If you have any further questions or need assistance, please feel free to contact us.
                            </span>
                        </div>

                    </div>
                  </div>

                  <!-- Order summary -->
                  <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                      <h3 class="sr-only">Items in your cart</h3>
                      <ul role="list" class="divide-y divide-gray-200">
                        <li class="flex px-4 py-6 sm:px-6">
                          <div class="flex-shrink-0">
                            <img :src="course.image" :alt="course.name" class="w-20 rounded-md" />
                          </div> 

                          <div class="ml-6 flex flex-1 flex-col">
                            <div class="flex">
                              <div class="min-w-0 flex-1">
                                <h4 class="text-sm">
                                  <p class="font-medium text-gray-700 hover:text-gray-800">{{ course.name }}</p>
                                </h4>
                                <!-- <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ product.size }}</p> -->
                              </div>
                            </div>
                            <div class="flex flex-1 items-end justify-between pt-2">
                              <p class="mt-1 text-sm font-medium text-gray-900">$ {{ course.amount }}</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                        <div class="flex items-center justify-between">
                          <dt class="text-sm">Subtotal</dt>
                          <dd class="text-sm font-medium text-gray-900">$ {{ course.amount }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                          <dt class="text-sm">Taxes</dt>
                          <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                          <dt class="text-base font-medium">Total</dt>
                          <dd class="text-base font-medium text-gray-900">$ 50.00</dd>
                        </div>
                      </dl>

                      <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                        <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm order</button>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
        </main>
    </div>
     <modal-success :action="modalSuccess.action"
                    :header="modalSuccess.header"
                    :message="modalSuccess.message"
                    :open="modalSuccess.show"/>

</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import HeaderSection from '@/Components/HeaderSection.vue'
import { reactive, ref } from 'vue';
import ModalSuccess from '@/Components/ModalSuccess.vue';

const props = defineProps({
    course: {
        type: Object,
    },
});

const selectedPaymentMethod = ref('direct-bank');


const form = useForm({
    email: null,
})

const modalSuccess = reactive({
    show: false,
    action: 'Finish',
    header: 'RFD Submitted',
    message: ''
})

const customPaymentMethods = [
    { id: 'direct-bank', title: 'Bank Transfer' },
    { id: 'crypto', title: 'Cryptocurrency' },
    // { id: 'paypal-radio', title: 'PayPal' },
]

function handlePaymentMethodChange(id) {
    selectedPaymentMethod.value = id;
    // if (id === 'paypal-radio') {
    //     loadScript({ 'client-id': CLIENT_ID }).then((paypal) => {
    //         paypal
    //             .Buttons({
    //                 createOrder,
    //                 onApprove,
    //             })
    //             .render('#paypal-button-container');
    //     });
    // }
}

function submitForm()
{
    form.post(route('lesson.purchase', props.course.id), {
        onSuccess: () => {
            modalSuccess.show = true
            form.email = ''
        },
    })
}

</script>