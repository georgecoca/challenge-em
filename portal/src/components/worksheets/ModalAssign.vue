<script setup>
import {watch, ref, computed} from 'vue';
import Modal from "@/components/ui/Modal.vue";
import Input from "@/components/ui/Input.vue";
import {CheckIcon} from '@heroicons/vue/20/solid';
import {useStudentsStore} from '@/store/users'
import useForm from "@/composables/useForm.js";
import Button from "@/components/ui/Button.vue";
import Toggle from "@/components/ui/Toggle.vue";

const studentsStore = useStudentsStore();

const model = defineModel();
const props = defineProps({
  worksheet: Object
});

const search = ref('');
const onlyAssigned = ref(false);

const form = useForm({
  worksheet_id: props.worksheet_id,
  user_id: null,
  toggle: null
});

async function toggleAssign(user) {
  if (isAssigned(user)) {
    form.toggle = 'remove';
  } else {
    form.toggle = 'add'
  }

  form.worksheet_id = props.worksheet.id;
  form.user_id = user.id;

  await form.post('/api/assignments');
  await fetchUsers();
}

function isAssigned(user) {
  return user.assignments.findIndex(a => a.worksheet_id === props.worksheet.id) > -1;
}

const fetchParams = computed(() => {
  return {
    with: ['assignments'],
    search: search.value,
    only_assigned: onlyAssigned.value ? 1 : 0,
    worksheet_id: props.worksheet.id,
    page: studentsStore.currentPage,
  }
});

async function fetchUsers() {
  return studentsStore.fetchItems(fetchParams.value);
}

watch(() => props.worksheet, () => {
  fetchUsers();
});

watch([search, onlyAssigned], (async () => {
  await fetchUsers();
}));
</script>

<template>
  <Modal v-model="model" title="Assign students to this worksheet">
    <p class="text-sm text-gray-500">
      {{ worksheet.id }}
      Search students and assign them to <span class="font-bold">
      “{{ worksheet?.name }}”
      </span> worksheet
    </p>

    <div class="mt-4">
      <Input v-model.lazy="search" class="w-full" placeholder="Search students"/>
    </div>

    <div class="mt-2">
      <Toggle
        v-model="onlyAssigned"
        enabled-text="Only assigned students"
        disabled-text="All students"
      />
    </div>

    <div class="mt-4 relative">
      <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"/>
      </div>
      <div class="relative flex justify-center">
        <span class="bg-white px-2 text-sm text-gray-500">Students</span>
      </div>
    </div>

    <div v-if="studentsStore.items">
      <ul  role="list" class="divide-y divide-gray-100">
        <li v-for="user in studentsStore.items.data" :key="user.email" class="flex items-center gap-x-6 py-5">
          <div class="flex  justify-center items-center bg-gray-100 p-2 rounded cursor-pointer size-10"
               @click="toggleAssign(user)">
            <CheckIcon v-if="isAssigned(user)" class="size-5 text-green-700" aria-hidden="true"/>
          </div>
          <div class="flex min-w-0 gap-x-4">
            <div class="min-w-0 flex-auto">
              <p class="text-sm/6 font-semibold text-gray-900">{{ user.name }}</p>
            </div>
          </div>
        </li>
      </ul>

      <div class="mt-4" v-if="studentsStore.items.data.length === 0">
        <div class="text-sm text-center">
          No students found
        </div>
      </div>
    </div>

    <div v-if="studentsStore.hasMore">
      <div class="flex justify-between">
        <Button variant="secondary" @click="model = false">Close</Button>
        <Button :processing="studentsStore.loading" @click="studentsStore.loadMore(fetchParams)">Load More</Button>
      </div>
    </div>

  </Modal>
</template>