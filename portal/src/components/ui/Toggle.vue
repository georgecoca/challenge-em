<script setup>
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

const props = defineProps({
  enabledText: String,
  disabledText: String,
})

// Define the v-model binding using defineModel
const enabled = defineModel('modelValue', {
  type: Boolean,
  default: false,
})
</script>

<template>
  <SwitchGroup as="div" class="flex items-center">
    <Switch
      v-model="enabled"
      :class="[enabled ? 'bg-sky-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-sky-600 focus:ring-offset-2 focus:outline-hidden']"
    >
      <span
        aria-hidden="true"
        :class="[enabled ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white ring-0 shadow-sm transition duration-200 ease-in-out']"
      />
    </Switch>
    <SwitchLabel as="span" class="ml-3 text-sm">
      <span class="text-gray-600">
        {{ enabled ? enabledText : disabledText }}
      </span>
    </SwitchLabel>
  </SwitchGroup>
</template>
