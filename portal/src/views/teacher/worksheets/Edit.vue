<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useWorksheetsStore } from '@/store/worksheets';
import Form from '@/views/teacher/worksheets/Form.vue';

const route = useRoute();
const worksheetsStore = useWorksheetsStore();

const initialName = ref('');
const initialQuestions = ref([]);

// Fetch the existing worksheet data on mount
onMounted(async () => {
  await worksheetsStore.fetchItem(route.params.id);
  initialName.value = worksheetsStore.item.name;
  initialQuestions.value = worksheetsStore.item.schema;
});
</script>

<template>
  <Form
    :initialName="initialName"
    :initialQuestions="initialQuestions"
    :submitUrl="`/api/worksheets/${route.params.id}`"
    method="put"
  >
    <template #submit-button>
      Update Worksheet
    </template>
  </Form>
</template>
