<script setup>
import Form from '@/views/teacher/worksheets/Form.vue';
</script>

<template>
  <Form submitUrl="/api/worksheets" method="post">
    <template #submit-button>
      Create Worksheet
    </template>
  </Form>
</template>
