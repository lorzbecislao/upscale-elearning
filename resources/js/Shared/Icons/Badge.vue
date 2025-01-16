<script setup>
import {ref, watch} from "vue"

const props = defineProps({
    status: Number,
    type: String,
})

const badgeClass = ref(null)
const description = ref(null)

watch(() => props.status, () => {
        switch (props.type) {
            case 'user':
                translateUser(props.status)
                break;
            default:
                break;
        }
    }, {immediate: true, deep: true}
)

function translateUser(status) {
    switch (status) {
        case 1:
            badgeClass.value = 'bg-green-100 text-green-800'
            description.value = 'Active'
            break;
        case 2:
            badgeClass.value = 'bg-orange-lighter text-orange'
            description.value = 'Inactive'
            break;
        case 3:
            badgeClass.value = 'bg-red-100 text-red-error'
            description.value = 'Deactivated'
            break;
        default:
            badgeClass.value = 'bg-gray-100 text-gray-900'
            description.value = 'None'
            break;
    }
}

</script>
<template>
    <div :class="badgeClass"
         class="inline-flex gap-2 items-center px-2.5 py-1.5 rounded-full font-heading font-medium text-xs">
        {{ description }}
    </div>
</template>
