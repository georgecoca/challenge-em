<script setup>
import { computed } from 'vue'
import { ArrowPathIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  processing: Boolean,
  variant: {
    type: String,
    default: 'primary', // default style
  },
});

const baseClasses = "flex justify-center items-center cursor-pointer rounded-md px-2.5 py-1.5 text-sm font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2";

const variantClasses = computed(() => {
  // Check if the variant is an outline variant
  const isOutline = props.variant.endsWith('-outline');
  // Extract the base variant (e.g. "secondary" from "secondary-outline")
  const baseVariant = isOutline ? props.variant.replace('-outline', '') : props.variant;

  switch (baseVariant) {
    case 'secondary':
      return isOutline
        ? "bg-white text-gray-900 ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
        : "bg-gray-200 text-black hover:bg-gray-300 focus-visible:outline-gray-600";
    case 'danger':
      return isOutline
        ? "bg-white text-red-600 ring-1 ring-red-300 ring-inset hover:bg-red-50"
        : "bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600";
    case 'success':
      return isOutline
        ? "bg-white text-green-600 ring-1 ring-green-300 ring-inset hover:bg-green-50"
        : "bg-green-600 text-white hover:bg-green-500 focus-visible:outline-green-600";
    case 'primary':
    default:
      return isOutline
        ? "bg-white text-sky-600 ring-1 ring-sky-300 ring-inset hover:bg-sky-50"
        : "bg-sky-600 text-white hover:bg-sky-500 focus-visible:outline-sky-600";
  }
});
</script>

<template>
  <button type="button" :class="[baseClasses, variantClasses]">
    <ArrowPathIcon v-if="processing" class="animate-spin h-5 w-5 mr-3"/>
    <slot/>
  </button>
</template>
