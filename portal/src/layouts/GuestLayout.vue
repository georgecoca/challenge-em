<script setup>
</script>

<template>
  <div class="h-full">
    <div class="flex min-h-full">
      <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-radial-[at_50%_0%] from-white to-sky-200 to-190%">
        <div class="mx-auto w-full max-w-sm lg:w-96">
          <router-view />
        </div>
      </div>
      <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 size-full object-cover" src="/src/assets/auth.jpg" alt="">
      </div>
    </div>
  </div>
</template>
