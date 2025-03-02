<script setup>
import Button from "@/components/ui/Button.vue";
import Modal from "@/components/ui/Modal.vue";
import {useWorksheetsStore} from "@/store/worksheets.js";

const worksheetsStore = useWorksheetsStore();

const props = defineProps({
  worksheet: Object
});

const model = defineModel();

const handleDelete = (async () => {
  await worksheetsStore.deleteItem(props.worksheet.id);
  model.value = false;
});

</script>

<template>
  <Modal v-model="model" title="Do you really want to delete the worksheet?">
    <p class="text-sm text-gray-500">
      Are you sure you want to permanently delete the worksheet <span class="font-bold">
      “{{ worksheet?.name }}”
      </span> worksheet?
      This action cannot be undone.
    </p>

    <template v-slot:footer>
      <div class="mt-4 flex justify-between gap-4">
        <Button
          type="button"
          variant="secondary"
          @click="model = false"
        >
          Cancel
        </Button>
        <Button
          type="button"
          variant="danger"
          @click="handleDelete"
        >
          Yes, delete it
        </Button>
      </div>
    </template>
  </Modal>
</template>