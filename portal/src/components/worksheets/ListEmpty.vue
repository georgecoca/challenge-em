<script setup>
import {computed} from 'vue';
import { PlusIcon } from '@heroicons/vue/20/solid';
import {useAuthStore} from "@/store/auth.js";

const authStore = useAuthStore();

const canCreate = computed(() => authStore.user.role === 'teacher');

</script>

<template>
  <div class="text-center">
    <svg class="mx-auto size-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
      <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
    </svg>
    <h3 class="mt-2 text-sm font-semibold text-gray-900">No worksheets found</h3>

    <p v-if="canCreate" class="mt-1 text-sm text-gray-500">
      Get started by creating a new worksheet.
    </p>

    <div class="mt-6" v-if="canCreate">
      <router-link
        :to="{ name: 'WorksheetsCreate' }"
        tag="button"
        class="inline-flex items-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-sky-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
      >
        <PlusIcon class="mr-1.5 -ml-0.5 size-5" aria-hidden="true" />
        New Worksheet
      </router-link>
    </div>
  </div>
</template>