<script setup>
import {onMounted, ref} from 'vue';
import {useApi} from '@/composables/useApi'
import {useAuthStore} from "@/store/auth.js";

const authStore = useAuthStore();
const {get} = useApi();

const stats = ref([
  {name: 'Worksheets created', stat: '-'},
  {name: 'Worksheets completed', stat: '-'},
]);

onMounted(async () => {
  const {data} = await get('/api/teacher/stats');
  stats.value = [
    {name: 'Worksheets created', stat: data.worksheets_created},
    {name: 'Worksheets completed', stat: data.worksheets_completed},
  ]
});
</script>

<template>
  <div>
    <h3 class="text-base font-semibold text-gray-900">
      Hi {{ authStore.user.name  }}!
    </h3>
    <div>
      Welcome to your dashboard—your quick glance at key metrics and insights!
    </div>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
      <div v-for="item in stats" :key="item.name"
           class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">{{ item.name }}</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ item.stat }}</dd>
      </div>
    </dl>
  </div>
</template>