<script setup>
import {onMounted, computed, ref, watch} from 'vue';
import ListCard from '@/components/worksheets/ListCard.vue'
import {useWorksheetsStore} from '@/store/worksheets'
import ListEmpty from "@/components/worksheets/ListEmpty.vue";
import Button from "@/components/ui/Button.vue";
import Input from "@/components/ui/Input.vue";
import ModalDelete from "@/components/worksheets/ModalDelete.vue";
import ModalAssign from "@/components/worksheets/ModalAssign.vue";

const worksheetsStore = useWorksheetsStore();

const selectedWorksheet = ref(null);
const showDeleteModal = ref(false);
const showAssignModal = ref(false);

onMounted(() => {
  fetchWorksheets()
});

function fetchWorksheets() {
  worksheetsStore.fetchItems({
    with_count: ['students'],
    search: search.value,
    page: worksheetsStore.currentPage
  });
}

const deleteWorksheet = (worksheet) => {
  selectedWorksheet.value = worksheet;
  showDeleteModal.value = true;
}

const assignWorksheet = (worksheet) => {
  selectedWorksheet.value = worksheet;
  showAssignModal.value = true;
}

const search = ref('');

watch(search, (async () => {
  fetchWorksheets()
}));

watch(showAssignModal, (async () => {
  if (showAssignModal.value === false) {
    fetchWorksheets()
  }
}));
</script>

<template>

  <div class="bg-white shadow-md items-center border rounded border-gray-200 p-4 sm:p-6 flex justify-between gap-4">
    <div class="flex flex-1 grow items-center">
      <div class="w-full md:w-auto">
        <Input v-model.lazy="search" placeholder="Search worksheets"/>
      </div>
    </div>

    <div class="flex justify-end">
      <RouterLink :to="{name: 'WorksheetsCreate'}">
        <Button class="hidden md:block">Create new worksheet</Button>
        <Button class="sm:block md:hidden">Create</Button>
      </RouterLink>
    </div>
  </div>

  <div class="mt-8 bg-white p-4 ">
    <ul v-if="worksheetsStore.items" role="list" class="mdivide-y divide-gray-100">
      <ListCard v-for="worksheet in worksheetsStore.items.data"
                :worksheet="worksheet"
                :key="worksheet.id"
                @delete="deleteWorksheet"
                @assign="assignWorksheet"
      />
    </ul>

    <ListEmpty v-if="worksheetsStore.isEmpty"/>
  </div>

  <div v-if="worksheetsStore.hasMore">
    <div class="flex justify-center">
      <Button :processing="worksheetsStore.loading" @click="worksheetsStore.loadMore()">Load More</Button>
    </div>
  </div>

  <ModalDelete v-model="showDeleteModal" :worksheet="selectedWorksheet"/>
  <ModalAssign v-model="showAssignModal" :worksheet="selectedWorksheet"/>
</template>