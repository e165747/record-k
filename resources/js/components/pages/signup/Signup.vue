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
        Sign up
      </v-card-title>
        <v-spacer></v-spacer>
      <v-btn
      icon
        @click="back"
      >
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
    </v-toolbar>  
    <v-form
      ref="form"
      v-model="isValid"
      class="pa-4 pt-6"
      @submit.prevent="signup"
    >
      <v-alert v-if="error" title="Error" type="error" prominent dismissible  @click.native="error = false" icon="mdi-alert-octagon">
        {{ errorMessage }}
      </v-alert>
      <v-text-field
        v-model="formValues.username"
        :rules="[rules.email]"
        color="gray"
        label="User name(email)"
        type="email"
        variant="filled"
      />
      <v-text-field
        v-model="formValues.password"
        :rules="[rules.length(6)]"
        color="gray"
        max="100"
        label="Password"
        type="password"
        variant="filled"
      />
      <v-text-field
        v-model="formValues.passwordConfirmation"
        :rules="[rules.passwordConfirmation]"
        color="gray"
        max="100"
        label="Password Confirmation"
        type="password"
        variant="filled"
      />
      <v-card-actions>
        <v-btn @click="clear">Clear</v-btn>
        <v-spacer></v-spacer>
        <v-btn color="primary" :disabled="!isValid" type="submit">Sign up</v-btn>
      </v-card-actions>
      </v-form>
      <Snackbar :snackbar="snackbar.show" :text="snackbar.text" />
  </v-card>
</template>

<script setup lang="ts">
import Snackbar from '@/components/molecules/Snackbar.vue';
import { useSignup } from '@/composables/pages/signup/useSignup'

const {
  form,
  formValues,
  error,
  errorMessage,
  signup,
  snackbar,
  isValid,
  rules,
  clear,
  back
} = useSignup()

</script>