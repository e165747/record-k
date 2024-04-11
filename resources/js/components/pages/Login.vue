<template>
  <form @submit.prevent="login">
    <input v-model="username" type="text" placeholder="Username" />
    <input v-model="password" type="password" placeholder="Password" />
    <button type="submit">Login</button>
  </form>
</template>

<script setup lang="ts">
import { useLogin } from '@/composables/pages/login/useLogin';
import axios from 'axios';
import { onMounted } from 'vue';

const { username, password, login, mounted } = useLogin();

onMounted(() => {
  console.log('Login page mounted');
  axios.get('/sanctum/csrf-cookie').then(response => {
    console.log(response)
    // ログイン…
  })
});
</script>