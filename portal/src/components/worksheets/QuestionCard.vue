<script setup>
import Input from "@/components/ui/Input.vue";
import Label from "@/components/ui/Label.vue";
import Textarea from "@/components/ui/Textarea.vue";
import { TrashIcon } from '@heroicons/vue/20/solid';
import InputError from "@/components/ui/InputError.vue";

defineProps({
  index: Number,
  errors: Object,
  question: {
    type: Object,
    required: true
  },
  disabled: {
    type: Boolean,
    required: false
  }
});
</script>

<template>
  <div class="p-4 bg-white border border-gray-200 shadow rounded">
    <!-- Word -->
    <div>
      <div class="flex items-center justify-between">
        <Label>Word</Label>

        <button v-if="!disabled" type="button" @click="$emit('remove')" class="text-red-500 hover:text-red-700">
          <TrashIcon class="h-5 w-5" />
        </button>
      </div>
      <div class="mt-2">
        <Input :disabled="disabled" v-model="question.word" placeholder="Enter word" />
        <InputError class="mt-1" :error="errors[`questions.${index}.word`]"/>
      </div>
    </div>

    <!-- Definition -->
    <div class="mt-4">
      <Label>Definition</Label>
      <div class="mt-2">
        <Textarea :disabled="disabled" v-model="question.definition" placeholder="Enter word definition" />
        <InputError class="mt-1" :error="errors[`questions.${index}.definition`]"/>
      </div>
    </div>
  </div>
</template>
