<script setup>
defineProps(['error']);
</script>

<template>
  <div v-if="error">
    <p class="text-sm text-red-600">
      {{ error[0] }}
    </p>
  </div>
</template>
