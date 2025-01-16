<script setup>
import { Link } from "@inertiajs/vue3"
import { ChevronRightIcon } from "@heroicons/vue/solid"

const props = defineProps({
    levels: Number,
    level1: { name: String, route: String, route_id: String },
    level2: { name: String, route: String, route_id: String },
    level3: { name: String, route: String, route_id: { type: String, default: null } },
    level4: { name: String, route: String, route_id: String },
})
</script>
<template>
    <nav aria-label="Breadcrumb" class="flex">
        <ol v-if="levels === 4" class="flex items-center space-x-4">
            <li>
                <div class="mb-1">
                    <Link class="text-sm font-heading leading-5 font-medium text-gray-500 hover:text-gray-700"
                        :href="route(level1.route, level1.route_id)">
                    {{ level1.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading leading-5 text-gray-500 hover:text-gray-700"
                        :href="route(level2.route, level2.route_id)">
                    {{ level2.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading leading-5 text-gray-500 hover:text-gray-700"
                        :href="route(level3.route, [level3.route_id])">
                    {{ level3.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading font-medium leading-5 text-black hover:text-gray-700"
                        :href="route(level4.route, level4.route_id)">
                    {{ level4.name }}
                    </Link>
                </div>
            </li>
        </ol>
        <ol v-else-if="levels === 3" class="flex items-center space-x-4">
            <li>
                <div class="mb-1">
                    <Link class="text-sm font-heading leading-5 font-medium text-gray-500 hover:text-gray-700"
                        :href="route(level1.route, level1.route_id)">
                    {{ level1.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading leading-5 text-gray-500 hover:text-gray-700"
                        :href="route(level2.route, level2.route_id)">
                    {{ level2.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading font-medium leading-5 text-black hover:text-gray-700"
                        :href="level3.route_id ? route(level3.route, [level3.route_id]) : route(level3.route)">
                    {{ level3.name }}
                    </Link>
                </div>
            </li>
        </ol>
        <ol v-else-if="levels === 2" class="flex items-center space-x-4">
            <li>
                <div class="mb-1">
                    <Link class="text-sm font-heading leading-5 font-medium text-gray-500 hover:text-gray-700"
                        :href="route(level1.route, level1.route_id)">
                    {{ level1.name }}
                    </Link>
                </div>
            </li>
            <li>
                <div class="flex items-center space-x-4">
                    <chevron-right-icon class="w-5 h-5 text-medium-gray" />
                    <Link class="text-sm font-heading leading-5 text-black hover:text-gray-700 font-medium"
                        :href="route(level2.route, level2.route_id)">
                    {{ level2.name }}
                    </Link>
                </div>
            </li>
        </ol>
        <div v-else>
            <Link class="text-2xl font-heading leading-normal text-black-darkest font-bold"
                :href="route(level1.route, level1.route_id)">
            {{ level1.name.length < 13 ? level1.name : level1.name.substring(0, 13) + "..." }} </Link>
        </div>
    </nav>
</template>
