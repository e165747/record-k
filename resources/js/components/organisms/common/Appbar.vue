<template>
 <v-app-bar app>
    <v-app-bar-title>
      Reco Log
      <v-icon>mdi-record-circle</v-icon>
    </v-app-bar-title>
    <!-- レコード一覧に遷移 -->
    <v-btn to="/">Records</v-btn>
    <v-btn to="/artists">Artists</v-btn>
    <v-spacer></v-spacer>
    <div class="mr-2">
      ようこそ、{{ props.userName }}さん
    </div>
    <v-btn variant="outlined" @click="logout">Logout</v-btn>
 </v-app-bar>
</template>

<script setup lang="ts">
import { useLogout } from '@/composables/pages/share/useLogout'
const { logout } = useLogout()
const props = defineProps<{
  userName: string
}>()
</script>