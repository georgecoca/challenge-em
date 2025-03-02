<script setup lang="ts">
import Button from "@/components/ui/Button.vue";

defineProps({
  users: Array
})
</script>

<template>
  <table class="min-w-full divide-y divide-gray-300">
    <thead>
    <tr>
      <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Worksheets Assigned</th>
      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Worksheets Completed
      </th>
      <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
        <span class="sr-only">Edit</span>
      </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    <tr v-for="student in users" :key="student.id">
      <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">{{
          student.name
        }}
      </td>
      <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">
        {{ student.assignments_count }}
      </td>
      <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">
        {{ student.completed_assignments_count }}
      </td>
      <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
        <RouterLink :to="{name: 'StudentsView', params: {id: student.id}}">
          <Button variant="secondary">View</Button>
        </RouterLink>
      </td>
    </tr>
    </tbody>
  </table>
</template>