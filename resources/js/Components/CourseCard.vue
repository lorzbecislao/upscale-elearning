<template>
    <div class="bg-white">
        <div class="mx-auto px-4 py-12 sm:px-6 sm:py-12 lg:max-w-7xl lg:px-8">
            <!-- Product -->
            <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                <!-- Product image -->
                <div class="lg:col-span-4 lg:row-end-1">
                    <div class="aspect-h-3 aspect-w-4 overflow-hidden rounded-lg bg-gray-100">
                        <img :src="image" :alt="title" class="object-cover object-center" />
                    </div>
                </div>

                <!-- Product details -->
                <div
                    class="mx-auto mt-14 max-w-2xl sm:mt-16 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none">
                    <div class="flex flex-col-reverse">
                        <div class="mt-4">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ title }}</h1>

                            <h2 id="information-heading" class="sr-only">Product information</h2>
                            <!-- <p class="mt-2 text-sm text-gray-500">
                Version {{ product.version.name }} (Updated <time :datetime="product.version.datetime">{{ product.version.date }}</time
                >)
              </p> -->
                        </div>
                    </div>

                    <p class="mt-6 text-gray-500">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec turpis a ante tristique fringilla.
                        Donec ut elit sed justo finibus finibus. Quisque at nunc augue. Aliquam volutpat augue ac ligula
                        scelerisque
                    </p>

                    <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <button @click="checkout()" type="button"
                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Buy
                            now</button>
                        <button @click=openCalendly() type="button"
                            class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-50 px-8 py-3 text-base font-medium text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Try
                            for free</button>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-900">Course Highlights</h3>
                        <div class="prose prose-sm mt-4 text-gray-500">
                            <ul role="list" class="list-disc">
                                <li v-for="highlight in content" :key="highlight">{{ highlight }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3'

export default {
    components: {
    },
    name: "CourseCard",
    props: {
        title: String,
        content: Array,
        slug: String,
        image: String,
        id: Number
    },
    data: () => ({
    }),
    setup(props) {
        const product = {
            name: 'Application UI Icon Pack',
            version: { name: '1.0', date: 'June 5, 2021', datetime: '2021-06-05' },
            price: '$220',
            description:
                'The Application UI Icon Pack comes with over 200 icons in 3 styles: outline, filled, and branded. This playful icon pack is tailored for complex application user interfaces with a friendly and legible look.',
            highlights: [
                '200+ SVG icons in 3 unique styles',
                'Compatible with Figma, Sketch, and Adobe XD',
                'Drawn on 24 x 24 pixel grid',
            ],
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-05-product-01.jpg',
            imageAlt: 'Sample of 30 icons with friendly and fun details in outline, filled, and brand color styles.',
        }

        const checkout = () => {
            router.get(route('lesson.checkout', props.id))
        };

        onMounted(() => {
            const link = document.createElement('link');
            link.href = 'https://assets.calendly.com/assets/external/widget.css';
            link.rel = 'stylesheet';
            document.head.appendChild(link);

            const script = document.createElement('script');
            script.src = 'https://assets.calendly.com/assets/external/widget.js';
            script.defer = true;
            // script.onload = () => {
            //     openCalendly();
            // };
            document.head.appendChild(script);
        });

        function openCalendly() {
            if (window.Calendly) {
                const options = {
                    url: 'https://calendly.com/elibecislao',
                };
                window.Calendly.initPopupWidget(options);
            } else {
                console.error('Calendly library not loaded.');
            }
        }

        return { product, checkout, openCalendly }
    },
}
</script>
