<script setup>
import {ref, computed} from 'vue';
import Select from "@/components/ui/Select.vue";
import Label from "@/components/ui/Label.vue";
import Textarea from "@/components/ui/Textarea.vue";

const props = defineProps({
  words: Array,
  question: {
    type: Object,
    required: true
  },
  assignment: {
    type: Object,
    required: true,
  },
  disabled: {
    type: Boolean,
    required: false
  }
});

const response = computed(() => props.assignment.response);
const answer = ref(response.value ? response.value[props.question.id] : '');

const cardClass = computed(() => {
  if (response.value) {

    if (props.question.id === response.value[props.question.id]) {
      return 'border-green-400'
    }

    return 'border-red-400'
  }

  return 'border-gray-200'
});

</script>

<template>
  <div class="p-4 bg-white border shadow rounded" :class="cardClass">
    <!-- Word -->
    <div>
      <div class="flex items-center justify-between">
        <Label>Word</Label>
      </div>

      <div class="mt-2">
        <Select v-model="answer"
                :disabled="disabled"
                @change="$emit('selected', answer)">
          <option value="">
            Select correct answer
          </option>
          <option v-for="word in words" :key="word.id" :value="word.id">
            {{ word.word }}
          </option>
        </Select>
      </div>
    </div>

    <!-- Definition -->
    <div class="mt-4">
      <Label>Definition</Label>
      <div class="mt-2">
        {{ question.definition }}
      </div>
    </div>
  </div>
</template>
