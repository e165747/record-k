<template>
  <v-app>
    <Appbar v-if="showAppbar" :user-name="username"/>
    <v-main>
      <router-view />
    </v-main>
    <v-footer app>
      <!-- フッターの内容 -->
    </v-footer>
  </v-app>
</template>

<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import Appbar from '@/components/organisms/common/Appbar.vue'
import { useRoute } from 'vue-router'
import { useLogin } from '@/composables/pages/login/useLogin';

const route = useRoute()
const showAppbar = computed(() => {
  return route.path !== '/login'
})
const { mounted, username } = useLogin()

watch(() => route.path, () => {
  mounted()
})
onMounted(() => {
  mounted()
})

</script>