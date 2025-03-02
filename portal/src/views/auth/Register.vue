<template>
  <div>
    <div>
      <img class="h-10 w-auto mx-auto" src="/src/assets/edumaster-1.svg" alt="EduMaster"/>
      <h2 class="mt-8 text-2xl/9 font-bold tracking-tight text-gray-900">Create a new account</h2>
      <p class="mt-2 text-sm/6 text-gray-500">
        Already a member?
        <RouterLink :to="{name: 'Login'}" class="font-semibold text-sky-600 hover:text-sky-500">
          Login
        </RouterLink>
      </p>
    </div>
    <div class="mt-10">
      <form action="#" method="POST" class="space-y-6" @submit.prevent="handleRegister">
        <div>
          <Label>Name</Label>
          <div class="mt-2">
            <Input v-model="form.name" required/>
            <InputError class="mt-1" :error="form.errors.name"/>
          </div>
        </div>

        <div>
          <Label>Are you a teacher or student?</Label>
          <div class="mt-2">
            <Select v-model="form.role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </Select>
            <InputError class="mt-1" :error="form.errors.role"/>
          </div>
        </div>

        <div>
          <Label>Email address</Label>
          <div class="mt-2">
            <Input v-model="form.email" type="email" autocomplete="email" required/>
            <InputError class="mt-1" :error="form.errors.email"/>
          </div>
        </div>

        <div>
          <Label>Password</Label>
          <div class="mt-2">
            <Input v-model="form.password" type="password" required/>
            <InputError class="mt-1" :error="form.errors.password"/>
          </div>
        </div>

        <div>
          <Label>Confirm Password</Label>
          <div class="mt-2">
            <Input v-model="form.password_confirmation" type="password" required/>
            <InputError class="mt-1" :error="form.errors.password"/>
          </div>
        </div>

        <div>
          <Button type="submit" :processing="form.processing" class="w-full">
            Register
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import {useRouter} from 'vue-router'
import {useAuthStore} from '@/store/auth'
import {useApi} from '@/composables/useApi';
import {useRouteHelper} from '@/composables/useRouteHelper';
import {getCsrfCookie} from '@/api/user'
import Label from "@/components/ui/Label.vue";
import Input from "@/components/ui/Input.vue";
import InputError from "@/components/ui/InputError.vue";
import useForm from "@/composables/useForm.js";
import Button from "@/components/ui/Button.vue";
import Select from "../../components/ui/Select.vue";


const router = useRouter();
const {get} = useApi();
const authStore = useAuthStore();
const { toRoute } = useRouteHelper();

const form = useForm({
  name: '',
  role: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const handleRegister = async () => {
  try {
    await getCsrfCookie()
    await form.post('/register');
    const user = await get('/api/user');
    authStore.setUser(user);
    router.push(toRoute('Dashboard'));
  } catch (error) {
      console.error('Register failed', error);
  }
}

</script>
