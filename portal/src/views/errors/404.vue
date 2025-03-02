<script>
import {defineComponent} from "vue";
import Button from "@/components/ui/Button.vue";

export default defineComponent({
  components: {Button}
})
</script>

<template>
  <div>
    <div>
      Oops! We can’t seem to find that page. It might have been moved or deleted. Try checking the URL or head back to
      the homepage to continue browsing.
    </div>

    <div class="mt-4">
      <RouterLink to="/">
        <Button>Go to home page</Button>
      </RouterLink>
    </div>
  </div>
</template>