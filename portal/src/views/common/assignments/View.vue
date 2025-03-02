<script setup>
import {onMounted, ref, computed} from 'vue';
import {useRoute, onBeforeRouteLeave} from 'vue-router';
import {useAuthStore} from '@/store/auth'
import {useAssignmentsStore} from '@/store/assignments'
import QuestionCard from "@/components/students/QuestionCard.vue";
import useForm from "@/composables/useForm.js";
import Button from "@/components/ui/Button.vue";
import InputError from "@/components/ui/InputError.vue";
import {useRouteHelper} from "@/composables/useRouteHelper.js";

const authStore = useAuthStore();
const assignmentsStore = useAssignmentsStore();
const { toRoute } = useRouteHelper();

const route = useRoute();
const form = useForm({
  answers: {}
});

// Fetch the existing worksheet data on mount
onMounted(async () => {
  await fetchAssignment();
});

onBeforeRouteLeave((to, from) => {
  assignmentsStore.resetState()
})

const assignment = computed(() => assignmentsStore.item);
const hasResponse = computed(() => !!assignment.value.response);
const canSubmit = computed(() => {
  if (authStore.user.role === 'teacher') {
    return false;
  }

  return !assignment.value.response;
});

const words = computed(() => {
  return assignment.value?.worksheet?.schema
    .map(q => {
      return {
        id: q.id,
        word: q.word,
      }
    })
    .sort(() => Math.random() - 0.5);
});

const pointWord = computed(() => {
  return assignment.value.score === 1 ? 'point' : 'points'
})

async function fetchAssignment() {
  await assignmentsStore.fetchItem(route.params.id, {
    with: ['worksheet']
  });
}

function setAnswer(question, id) {
  form.answers[question.id] = id;
}

async function handleSubmit() {
  await form.put(`/api/assignments/${assignment.value.id}`)
  await fetchAssignment();
}
</script>

<template>
  <div v-if="assignment">
    <h2 class="text-2xl">{{ assignment.worksheet.name }}</h2>

    <!-- Cards -->
    <div class="mt-4 grid md:grid-cols-2 gap-4">
      <div
        v-for="(question, index) in assignment.worksheet.schema"
        :key="question.id"
        class="flex flex-col"
      >
        <QuestionCard
          @selected="setAnswer(question, $event)"
          :assignment="assignment"
          :words="words"
          :disabled="!canSubmit"
          class="flex-grow"
          :question="question"
          :index="index"
          :errors="[]"
        />
      </div>
    </div>

    <div v-if="form.errors.answers" class="bg-red-100 p-4 mt-4 rounded-md">
      <InputError :error="form.errors.answers"/>
    </div>

    <hr class="my-8 text-gray-200">

    <!-- Submit -->
    <div v-if="canSubmit">
      <div class="mt-4 flex justify-center items-center">
        <Button :processing="form.processing" @click="handleSubmit">
          <slot name="submit-button">Submit answers</slot>
        </Button>
      </div>
    </div>

    <!-- Submit -->
    <div v-if="hasResponse && !canSubmit">
      <div class="mt-4 flex justify-center items-center">
        You obtained a score of {{ assignment.score }} {{ pointWord }} out of {{ assignment.worksheet.schema.length }}.
      </div>

      <div class="mt-4 flex justify-center">
        <RouterLink :to="toRoute('Dashboard')">
          <Button>Go to Dashboard</Button>
        </RouterLink>
      </div>
    </div>
  </div>
</template>
