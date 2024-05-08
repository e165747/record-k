<template>
  <form @submit.prevent="login">
    <input v-model="username" type="text" required placeholder="Username" />
    <input v-model="password" type="password" required placeholder="Password" />
    <button type="submit">Login</button>
  </form>
</template>

<script setup lang="ts">
import { useLogin } from '@/composables/pages/login/useLogin';
import { onMounted } from 'vue';

const { username, password, login, mounted } = useLogin();

onMounted(() => {
  mounted();
});
</script>