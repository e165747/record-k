<template>
  <v-card
    class="mx-auto"
    style="max-width: 500px;"
  >
    <v-toolbar
      color="grey lighten-3"
      cards
      dark
      flat
    >
      <v-card-title class="text-h6 font-weight-regular">
        Login
      </v-card-title>
    </v-toolbar>  
    <v-form
      ref="form"
      v-model="isValid"
      class="pa-4 pt-6"
      @submit.prevent="login"
    >
      <v-alert v-if="error" title="Error" type="error" prominent dismissible  @click.native="error = false" icon="mdi-alert-octagon">
        {{ errorMessage }}
      </v-alert>
      <v-text-field
        v-model="username"
        :rules="[rules.email]"
        color="gray"
        label="User name(email)"
        type="email"
        variant="filled"
      ></v-text-field>
      <v-text-field
        v-model="password"
        :rules="[rules.length(6)]"
        color="gray"
        counter="100"
        label="Password"
        type="password"
        variant="filled"
      ></v-text-field>
      <v-card-actions>
        <v-btn @click="clear">Clear</v-btn>
        <v-spacer></v-spacer>
        <v-btn color="primary" :disabled="!isValid" type="submit">Login</v-btn>
      </v-card-actions>
      </v-form>
  </v-card>
</template>

<script setup lang="ts">
import { useLogin } from '@/composables/pages/login/useLogin'
import { onMounted } from 'vue'

const {
  form,
  username,
  password,
  error,
  errorMessage,
  login,
  isValid,
  mounted,
  rules,
  clear
} = useLogin()

onMounted(() => {
  mounted()
})
</script>