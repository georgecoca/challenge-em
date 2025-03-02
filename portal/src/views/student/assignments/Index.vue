<script setup>
import {onMounted, ref, watch} from 'vue';
import ListCard from '@/components/worksheets/ListCard.vue'
import {useAssignmentsStore} from '@/store/assignments'
import ListEmpty from "@/components/worksheets/ListEmpty.vue";
import Button from "@/components/ui/Button.vue";
import Input from "@/components/ui/Input.vue";
import Toggle from "@/components/ui/Toggle.vue";

const assignmentsStore = useAssignmentsStore();

const search = ref('');
const status = ref(false);

onMounted(() => {
  fetchWorksheets()
});

function fetchWorksheets() {
  assignmentsStore.fetchItems({
    with: ['worksheet'],
    search: search.value,
    status: status.value,
    page: assignmentsStore.currentPage
  });
}

watch([search, status], (async () => {
  fetchWorksheets()
}));
</script>

<template>

  <div class="bg-white shadow-md items-center border rounded border-gray-200 p-4 sm:p-6 flex justify-between gap-4">
    <div class="flex flex-1 grow items-center">
      <div class="w-full md:w-auto">
        <Input v-model.lazy="search" placeholder="Search worksheets"/>
      </div>
    </div>
    <div>
      <Toggle
        v-model="status"
        enabled-text="Completed"
        disabled-text="Pending"
      />
    </div>
  </div>

  <div class="mt-4 bg-white p-4 ">
    <ul v-if="assignmentsStore.items" role="list" class="divide-y divide-gray-100">
      <ListCard v-for="assignment in assignmentsStore.items.data"
                :show-options="false"
                :assignment="assignment"
                :worksheet="assignment.worksheet"
                :key="assignment.id"
      />
    </ul>

    <ListEmpty v-if="assignmentsStore.isEmpty"/>
  </div>

  <div v-if="assignmentsStore.hasMore">
    <div class="flex justify-center">
      <Button :processing="assignmentsStore.loading" @click="assignmentsStore.loadMore()">Load More</Button>
    </div>
  </div>
</template>