<script setup>
import {useAuthStore} from "@/store/auth.js";
import {useRouter} from 'vue-router'
import Navigation from "@/layouts/partials/Navigation.vue";

const authStore = useAuthStore();
const router = useRouter()

const goBack = () => {
  router.go(-1)
}
</script>

<template>
  <div v-if="authStore.isAuthenticated"
       class="min-h-full bg-radial-[at_0%_0%] from-sky-100 via-gray-50 to-white to-90%">
    <Navigation/>

    <div class="py-10">
      <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center">
            {{ $route.meta.title }}
          </h1>
        </div>
      </header>
      <main>
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          <RouterView/>
        </div>
      </main>
    </div>
  </div>
</template>