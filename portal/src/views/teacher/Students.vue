<script setup>
import {onBeforeRouteLeave} from 'vue-router'
import {ref, watch, onMounted, computed} from 'vue';
import Button from "@/components/ui/Button.vue";
import {useStudentsStore} from "@/store/users.js";
import Table from "@/components/students/Table.vue";
import Input from "@/components/ui/Input.vue";
import ListEmpty from "@/components/shared/ListEmpty.vue";

const studentsStore = useStudentsStore();

const search = ref('');

const fetchParams = computed(() => {
  return {
    'with_count': ['assignments', 'completedAssignments'],
    search: search.value,
    page: studentsStore.currentPage,
  }
});

function fetchStudents() {
  studentsStore.fetchItems(fetchParams.value);
}


onMounted(async () => {
  fetchStudents()
});

onBeforeRouteLeave((to, from) => {
  studentsStore.resetState()
})

watch(search, (async () => {
  fetchStudents()
}));

</script>

<template>
  <div class="bg-white shadow-md items-center border rounded border-gray-200 p-4 sm:p-6">
    <div class="w-full md:w-1/3">
      <Input v-model.lazy="search" placeholder="Search students"/>
    </div>
  </div>

  <div class="bg-white rounded-md">
    <div v-if="studentsStore.items" class="mt-8 px-4 sm:px-6 lg:px-8 ">
      <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <Table :users="studentsStore.items.data"/>
          </div>

          <div v-if="studentsStore.hasMore">
            <div class="flex justify-center">
              <Button :processing="studentsStore.loading" @click="studentsStore.loadMore(fetchParams)">Load More
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ListEmpty class="mt-8 pb-8" v-if="studentsStore.isEmpty">
      No students founds yet.
    </ListEmpty>
  </div>
</template>