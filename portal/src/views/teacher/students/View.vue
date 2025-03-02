<script setup>
import {onMounted, computed} from 'vue'
import {useRoute} from 'vue-router'
import {useStudentsStore} from "@/store/users.js";
import {useAssignmentsStore} from "@/store/assignments.js";
import ProfileHeader from "@/components/students/ProfileHeader.vue";
import ListCard from "@/components/worksheets/ListCard.vue";
import ListEmpty from "@/components/worksheets/ListEmpty.vue";

const studentsStore = useStudentsStore();
const assignmentsStore = useAssignmentsStore();

const route = useRoute();

onMounted(async () => {
  await studentsStore.fetchItem(route.params.id, {
    with_count: ['assignments', 'completedAssignments'],
  });

  await assignmentsStore.fetchItems({
    user_id: route.params.id,
    with: ['worksheet']
  });
});

const user = computed(() => studentsStore.item);

const stats = [
  { label: 'Vacation days left', value: 12 },
  { label: 'Sick days left', value: 4 },
  { label: 'Personal days left', value: 2 },
]
</script>

<template>
  <ProfileHeader v-if="user" :user="user"/>

  <div class="mt-4 bg-white p-4">

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


</template>