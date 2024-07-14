<template>
  <v-app>
    <Appbar v-if="showAppbar"/>
    <v-main>
      <router-view />
    </v-main>
    <v-footer app>
      <!-- フッターの内容 -->
    </v-footer>
  </v-app>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import Appbar from '@/components/organisms/Appbar.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const showAppbar = computed(() => {
  return route.path !== '/login'
})

</script>