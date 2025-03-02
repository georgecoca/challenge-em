<script setup>
import { watch } from 'vue'
import { useRouter } from 'vue-router'
import Input from "@/components/ui/Input.vue";
import Label from "@/components/ui/Label.vue";
import Button from "@/components/ui/Button.vue";
import QuestionCard from "@/components/Worksheets/QuestionCard.vue";
import QuestionPlaceholder from "@/components/Worksheets/QuestionPlaceholder.vue";
import InputError from "@/components/ui/InputError.vue";
import useForm from "@/composables/useForm.js";
import { v4 as uuidv4 } from 'uuid';

const props = defineProps({
  initialName: {
    type: String,
    default: ''
  },
  initialQuestions: {
    type: Array,
    default: () => []
  },
  submitUrl: {
    type: String,
    required: true
  },
  method: {
    type: String,
    default: 'post'  // Accepts 'post' or 'put'
  }
});

const emit = defineEmits(['submitted']);

const router = useRouter();

// Initialize form with provided initial data
const form = useForm({
  name: props.initialName,
  questions: props.initialQuestions
});

// In case the initial values change later (for example, when data loads in Edit)
watch(
  () => props.initialName,
  (newName) => {
    form.name = newName;
  }
);
watch(
  () => props.initialQuestions,
  (newQuestions) => {
    form.questions = newQuestions;
  }
);

// Common methods for adding/removing questions
function addQuestion() {
  form.questions.push({
    id: uuidv4(),
    word: '',
    definition: ''
  });
}

function removeQuestion(index) {
  form.questions.splice(index, 1);
}

async function handleSubmit() {
  try {
    if (props.method === 'post') {
      await form.post(props.submitUrl);
    } else {
      await form.put(props.submitUrl);
    }
    emit('submitted');
    router.push({name: 'Worksheets'});
  } catch (error) {
    // handle errors if needed
  }
}
</script>

<template>
  <div>
    <!-- Worksheet Name -->
    <Label>Name</Label>
    <div class="mt-2">
      <Input v-model="form.name" placeholder="Enter worksheet name"/>
      <InputError class="mt-1" :error="form.errors.name"/>
    </div>

    <!-- Questions List with Transition -->
    <TransitionGroup
      class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 items-stretch"
      tag="div"
      enter-active-class="transition duration-500 transform"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition duration-300 transform"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-for="(question, index) in form.questions"
        :key="question.id"
        class="flex flex-col"
      >
        <QuestionCard
          class="flex-grow"
          :question="question"
          :index="index"
          :errors="form.errors"
          @remove="removeQuestion(index)"
        />
        <InputError class="mt-1" :error="form.errors.questions"/>
      </div>

      <!-- Placeholder Card with Button to Add New Question -->
      <div class="flex flex-col" key="add-question">
        <QuestionPlaceholder @click="addQuestion"/>
      </div>
    </TransitionGroup>

    <!-- Submit Section -->
    <div v-if="form.questions.length > 0">
      <hr class="my-8 text-gray-200">
      <div class="mt-4 flex justify-center items-center">
        <Button :processing="form.processing" @click="handleSubmit">
          <slot name="submit-button">Submit</slot>
        </Button>
      </div>
    </div>
  </div>
</template>
