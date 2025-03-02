<script setup>
import Button from "@/components/ui/Button.vue";
import {PlusIcon, TrashIcon} from '@heroicons/vue/20/solid';
</script>

<template>
  <div key="placeholder-add" class="min-h-[258px] cursor-pointer">
    <div class="p-4 bg-white border border-gray-300 shadow rounded h-full flex items-center justify-center">
      <button type="button" class="cursor-pointer inline-flex items-center gap-x-1.5 text-gray-900 font-semibold">
        <PlusIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        <span>Add Word & Definition</span>
      </button>
    </div>
  </div>
</template>