<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { ref, nextTick, computed, watch, toRefs, watchEffect } from 'vue';
import { router } from "@inertiajs/vue3";

const emit = defineEmits(['emit-page', 'emit-specific-page']);

const props = defineProps({
    pagination: Object,
    current_page: Number,
    last_page: Number,
    next_page_url: String,
    prev_page_url: String,
    total_pages: Number,
    search: String,
    sortColumn: String,
    sortDirection: String,
    path: String
})

const class_distributable = ref('distributable: "-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 cursor-pointer')

const handlePrev = () => {
    if (props.prev_page_url) {
        nextTick(() => {
            emit('emit-page', props.prev_page_url);
        });
    }
};


const handleNext = () => {
    if (props.next_page_url) {
        nextTick(() => {
            emit('emit-page', props.next_page_url);
        });
    }
};

const toPage = (page) => {
    if (page && page != props.current_page) {
        nextTick(() => {
            emit('emit-specific-page', page);
        });
    }
};

const group = {
    left: ref([]),
    right: ref([])
};

const boundary = ref(3);

watch(() => props.pagination, () => {
    group.left.value = [];
    group.right.value = [];

    if (props.pagination.last_page > 6) {
        let half = 0;
        if ((props.pagination.last_page % 2) === 0) {
            half = props.pagination.last_page / 2;
        } else {
            half = (props.pagination.last_page - 1) / 2;
            half += 1;
        }

        let index = props.pagination.current_page;
        if (index <= half) {
            let total = props.pagination.last_page;
            for (let i = 1; i <= boundary.value; i++) {
                group.right.value.unshift(total);
                total -= 1;
            }

            if (props.pagination.current_page > 1) {
                index -= 1;
                if ((half - 1) === index) {
                    index -= 1;
                }
            }

            for (let i = 1; i <= boundary.value; i++) {
                if (index <= half) {
                    group.left.value.push(index);
                    index += 1;
                }
            }
        } else {
            group.left.value = [];
            group.right.value = [];

            for (let i = 1; i <= boundary.value; i++) {
                group.left.value.push(i);
            }

            if (props.pagination.current_page > (half + 1)) {
                index -= 1;
                if ((half - 1) === index) {
                    index -= 1;
                }
            }

            for (let i = 1; i <= boundary.value; i++) {
                if (index <= props.pagination.last_page) {
                    group.right.value.push(index);
                    index += 1;
                }
            }
        }
    } else {
        for (let i = 1; i <= props.pagination.last_page; i++) {
            group.left.value.push(i);
        }
    } 
})

</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white py-3">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ current_page }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ last_page }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ total_pages }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#" @click="handlePrev"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </a>

                    <a v-for="page in group.left.value"
                        :class="[class_distributable,(page === pagination.current_page ? '!bg-indigo-50' : '')]"
                        @click="toPage(page)">
                        <span v-text="page"></span>
                    </a>
                    <a :class="class_distributable + (pagination.last_page > 6 ? ' inline-block' : ' hidden')">
                        <span>...</span>
                    </a>
                    <a v-for="page in group.right.value"
                        :class="[class_distributable, (page === pagination.current_page ? '!bg-indigo-50' : '')]"
                        @click="toPage(page)">
                        <span v-text="page"></span>
                    </a>

                    <a href="#" @click="handleNext"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

