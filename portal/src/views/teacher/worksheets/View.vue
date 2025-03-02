<script setup>
import { onMounted, ref, computed } from 'vue';
import { useRoute, onBeforeRouteLeave } from 'vue-router';
import { useWorksheetsStore } from '@/store/worksheets';
import QuestionCard from "@/components/worksheets/QuestionCard.vue";

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

onBeforeRouteLeave((to, from) => {
  worksheetsStore.resetState()
})

const worksheet = computed(() => worksheetsStore.item);

</script>

<template>

  <div v-if="worksheet">
    <h2 class="text-2xl">{{ worksheet.name }}</h2>

    <!-- Cards -->
    <div class="mt-4 grid grid-cols-2 gap-4">
      <div
        v-for="(question, index) in worksheet.schema"
        :key="question.id"
        class="flex flex-col"
      >
        <QuestionCard
          :disabled="true"
          class="flex-grow"
          :question="question"
          :index="index"
          :errors="[]"
        />
      </div>
    </div>
  </div>
</template>
