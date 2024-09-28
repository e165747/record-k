<template>
 <v-app-bar app>
    <v-app-bar-title>
      Reco Log
      <v-icon>mdi-record-circle</v-icon>
    </v-app-bar-title>
    <v-spacer></v-spacer>
    <v-btn variant="outlined" @click="logout">Logout</v-btn>
 </v-app-bar>
</template>

<script setup lang="ts">
import { useLogout } from '@/composables/pages/share/useLogout'
const { logout } = useLogout()
</script>