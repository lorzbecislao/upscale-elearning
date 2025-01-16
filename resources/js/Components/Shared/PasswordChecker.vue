<script setup>
import CheckIcon from "@/Components/Icon/CheckIcon.vue"

defineProps({
  contains_eight_characters: Boolean,
  contains_number: Boolean,
  contains_uppercase: Boolean,
  contains_lowercase: Boolean
});
</script>

<template>
  <div class="relative flex-col justify-center">
    <div :class="{ is_text_valid: contains_eight_characters }" class="text-gray-500 text-sm">
      <li class="flex items-center">
        <check-icon :active="contains_eight_characters" :class="{ is_check_valid: contains_eight_characters }"/>
        <p class="ml-3 text-dark">At least 8-10 characters long</p>
      </li>
    </div>
    <div :class="{ is_text_valid: contains_uppercase }" class="text-gray-500 text-sm mt-2">
      <li class="flex items-center">
        <check-icon :active="contains_uppercase" :class="{ is_check_valid: contains_uppercase }"/>
        <p class="ml-3 text-dark">At least one uppercase letter</p>
      </li>
    </div>
    <div :class="{ is_text_valid: contains_lowercase }" class="text-gray-500 text-sm mt-2">
      <li class="flex items-center">
        <check-icon :active="contains_lowercase" :class="{ is_check_valid: contains_lowercase }"/>
        <p class="ml-3 text-dark">At least one lowercase letter</p>
      </li>
    </div>
    <div :class="{ is_text_valid: contains_number }" class="text-gray-500 text-sm mt-2">
      <li class="flex items-center">
        <check-icon :active="contains_number" :class="{ is_check_valid: contains_number }"/>
        <p class="ml-3 text-dark">At least one number</p>
      </li>
    </div>
  </div>
</template>

<style scoped>
.is_check_valid {
  color: #187a22;
}

.is_text_valid {
  color: black
}
</style>

