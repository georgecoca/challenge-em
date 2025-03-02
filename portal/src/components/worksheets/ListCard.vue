<script setup>
import { useRouter } from 'vue-router'
import MenuOptions from "@/components/ui/MenuOptions.vue";
import {useTimeAgo} from '@vueuse/core'
import Button from "@/components/ui/Button.vue";
import {useRouteHelper} from "@/composables/useRouteHelper.js";

const router = useRouter();
const { toRoute } = useRouteHelper();

defineProps({
  assignment: Object,
  worksheet: Object,
  showOptions: {
    type: Boolean,
    default: true,
  }
});

const emit = defineEmits(['delete', 'assign']);

const statuses = {
  true: 'text-green-700 bg-green-50 ring-green-600/20',
  false: 'text-gray-600 bg-gray-50 ring-gray-500/10',
}

const menuItems = [
  {
    id: 'assign',
    name: 'Assign',
    handle: (worksheet) => {
      emit('assign', worksheet);
    }
  },
  {
    id: 'edit',
    name: 'Edit',
    handle: (worksheet) => router.push({name: 'WorksheetsEdit', params: {id: worksheet.id}})
  },
  {
    id: 'delete',
    name: 'Delete',
    handle: (worksheet) => {
      emit('delete', worksheet);
    }
  }
]
</script>

<template>
  <li class="flex items-center justify-between gap-x-6 py-5">
    <div class="min-w-0">
      <div class="flex items-start gap-x-3">
        <p class="text-sm/6 font-semibold text-gray-900">{{ worksheet.name }}</p>
        <p v-if="showOptions"
           :class="[statuses[worksheet.students_count > 0], 'mt-0.5 rounded-md px-1.5 py-0.5 text-xs font-medium whitespace-nowrap ring-1 ring-inset']">
          {{ worksheet.students_count ? worksheet.students_count : 'none' }} assigned
        </p>
        <div v-if="assignment"
             :class="[statuses[assignment.completed], 'mt-0.5 rounded-md px-1.5 py-0.5 text-xs font-medium whitespace-nowrap ring-1 ring-inset']">
          {{ assignment.completed ? 'completed' : 'not completed' }}
        </div>
      </div>
      <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
        <p class="whitespace-nowrap">
          <span v-if="assignment">Assigned {{ useTimeAgo(new Date(assignment.created_at)) }}</span>
          <span v-else>Created {{ useTimeAgo(new Date(worksheet.created_at)) }}</span>
        </p>
      </div>
    </div>

    <!-- Options -->
    <div v-if="showOptions" class="flex flex-none items-center gap-x-4">
      <Button href="javascript:" variant="secondary-outline" @click="$emit('assign', worksheet)">
        Assign students
      </Button>
      <MenuOptions :resource="worksheet" :menu-items="menuItems"/>
    </div>

    <!-- Actions -->
    <div v-if="assignment">
      <RouterLink :to="toRoute('AssignmentsView', {id: assignment.id})">
        <Button variant="secondary-outline">
          View worksheet
        </Button>
      </RouterLink>
    </div>
  </li>
</template>