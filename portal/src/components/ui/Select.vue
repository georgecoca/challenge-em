<script setup>
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
const modelValue = defineModel();
</script>

<template>
  <div class="mt-2 grid grid-cols-1">
    <select v-bind="$attrs" v-model="modelValue" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-600 sm:text-sm/6">
      <slot/>
    </select>
    <ChevronDownIcon class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" aria-hidden="true" />
  </div>
</template>