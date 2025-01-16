<script setup>
import { onMounted, reactive, ref } from "vue"
import { v4 as uuid } from 'uuid'
import { useForm } from "@inertiajs/vue3"
import XCloseIcon from "@/Components/Icon/XCloseIcon.vue"

// Register all your emits here
const emit = defineEmits(["error", 'uploaded', 'clear']);

// Props
const props = defineProps({
    attachments: { type: [Array, Object], default: null },
    id: {
        type: String,
        default() {
            return `upload-section-${uuid()}`
        },
    },
    requirement: Object,
    savedImage: String,
    page: { type: String, default: 'sale' },
    type: {
        type: String,
        default: 'all'
    }
})

const file = ref(null)

const imagePreview = ref(null)

// Functions
function dragleave(event) {
    event.currentTarget.classList.add('bg-accent')
    event.currentTarget.classList.remove('bg-purple-200')
}

function dragover(event) {
    event.preventDefault()
    if (!event.currentTarget.classList.contains('bg-purple-200')) {
        event.currentTarget.classList.remove('bg-accent')
        event.currentTarget.classList.add('bg-purple-50')
    }
}

function drop(event) {
    event.preventDefault();
    file.value = event.dataTransfer.files[0]
    emit('uploaded', file.value);
    event.currentTarget.classList.add('bg-accent')
    event.currentTarget.classList.remove('bg-purple-200')
}

function onChange() {
    let validFileTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
    file.value = loginPhoto.files[0];

    if (!file.value) {
        return;
    }

    const reader = new FileReader();
    reader.readAsDataURL(file.value);
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
        emit('uploaded', file.value);
    };
}

const image = ref(props.savedImage ? props.savedImage : '')


function handleRemoveImage(index, id) {
    imagePreview.value = null;
    image.value = null
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.value = null;
    }
}

function handleViewDocument(image) {
    
}


function resetUploader() {
    file.value = null;
    imagePreview.value = null;
}

</script>

<template>
    <div class="bg-white">
        <div class="flex-1 h-full justify-center items-center content-stretch rounded-2xl border-2 border-dashed border-gray-300"
            @dragleave="dragleave" @dragover="dragover" @drop="drop">
            <div>
                <div v-if="imagePreview === null && image">
                    <div class="relative cursor-pointer">
                        <div class="absolute top-1 right-1 rounded-full bg-white p-1 cursor-pointer"
                            @click="handleRemoveImage(null, null)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <img :src="image" alt="" class="w-full h-[300px] bg-medium-dark object-scale-down rounded-2xl"
                            @click="handleViewDocument(image)" />
                    </div>
                </div>
                <div v-else>
                    <div v-if="imagePreview" class="relative">
                        <div class="absolute top-1 right-1 rounded-full bg-white p-1 cursor-pointer"
                            @click="handleRemoveImage()">
                            <x-close-icon class="w-5 h-5 text-medium-dark" />
                        </div>
                        <img :src="imagePreview" alt=""
                            class="w-full h-[300px] bg-medium-dark object-cover object-scale-down rounded-2xl" />
                    </div>
                </div>
            </div>
            <div v-if="!imagePreview && !image" class="flex flex-col items-center mx-auto py-6 gap-1">
                <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.1665 26.6665L14.8095 19.0235C16.1112 17.7218 18.2218 17.7218 19.5235 19.0235L27.1665 26.6665M23.8332 23.3332L26.4761 20.6902C27.7779 19.3884 29.8884 19.3884 31.1902 20.6902L33.8332 23.3332M23.8332 13.3332H23.8498M10.4998 33.3332H30.4998C32.3408 33.3332 33.8332 31.8408 33.8332 29.9998V9.99984C33.8332 8.15889 32.3408 6.6665 30.4998 6.6665H10.4998C8.65889 6.6665 7.1665 8.15889 7.1665 9.99984V29.9998C7.1665 31.8408 8.65889 33.3332 10.4998 33.3332Z"
                        stroke="#878CA6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex items-center gap-1 text-sm">
                    <label class="relative cursor-pointer text-gray-600 font-medium text-sm" for="loginPhoto">
                        <span class="text-primary font-bold hover:underline">Upload a photo</span>
                        <input @click="resetUploader" accept=".jpg,.jpeg,.png"
                            class="w-px h-px opacity-0 overflow-hidden absolute" id="loginPhoto" ref="loginPhoto"
                            type="file" @change="onChange" />
                    </label>
                    <p class="text-gray-600 font-medium">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">
                    PNG, JPG, JPEG up to 10MB</p>
            </div>
        </div>
    </div>
</template>
