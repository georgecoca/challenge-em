<script setup>
import { useTimeAgo } from '@vueuse/core'

const props = defineProps({
  user: Object
})

const stats = [
  { label: 'Assignments', value:  props.user.assignments_count},
  { label: 'Completed', value:  props.user.completed_assignments_count},
]
</script>

<template>
  <div v-if="user" class="overflow-hidden rounded-lg bg-white shadow-sm">
    <div class="bg-white p-6">
      <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex sm:space-x-5">
          <div class="shrink-0">
            <span class="bg-gray-200 flex items-center justify-center size-20 rounded-full">
              {{ user.name[0] }}
            </span>
          </div>
          <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
            <p class="text-xl font-bold text-gray-900 sm:text-2xl">{{ user.name }}</p>
            <p class="text-sm font-medium text-gray-600">
              Registered {{ useTimeAgo(new Date(user.created_at)) }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-1 divide-y divide-gray-200 border-t border-gray-200 bg-gray-50 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
      <div v-for="stat in stats" :key="stat.label" class="px-6 py-5 text-center text-sm font-medium">
        <span class="text-gray-900">{{ stat.value }}</span>
        {{ ' ' }}
        <span class="text-gray-600">{{ stat.label }}</span>
      </div>
    </div>
  </div>
</template>