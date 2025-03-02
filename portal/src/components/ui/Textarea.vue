<script setup>
defineProps({
    rows: {
      default: 4
    }
});

const modelValue = defineModel(String, '');
</script>

<template>
  <textarea :rows="rows"
            :value="modelValue"
            @input="modelValue = $event.target.value"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-600 sm:text-sm/6" />
</template>
