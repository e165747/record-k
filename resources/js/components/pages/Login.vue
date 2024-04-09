<template>
  <form @submit.prevent="login">
    <input v-model="username" type="text" placeholder="Username" />
    <input v-model="password" type="password" placeholder="Password" />
    <button type="submit">Login</button>
  </form>
</template>

<script setup lang="ts">
import { useLogin } from '@/composables/pages/login/useLogin';

const { username, password, login } = useLogin();
</script>