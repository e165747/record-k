<template>
  <v-app>
    <div v-if="store.state.loading.isLoading" id="loading">
      <v-progress-circular indeterminate />
    </div>
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
import { computed, watch } from 'vue'
import Appbar from '@/components/organisms/common/Appbar.vue'
import { useRoute } from 'vue-router'
import { useLogin } from '@/composables/pages/login/useLogin';
import { useStore } from 'vuex';

const route = useRoute()
const excludeAppbarPaths = ['/sign-up', '/login']
const excludeSigninPaths = ['/sign-up']
const showAppbar = computed(() => {
  return excludeAppbarPaths.every(path => path !== route.path)
})
const { mounted, username } = useLogin()
const store = useStore()

watch(() => route.path, () => {
  if (!excludeSigninPaths.some(path => path === route.path)) {
    mounted()
  }
})

</script>
<style lang="scss">
#loading {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
  z-index: 9999;
  position: fixed;
  background-color: rgba(#000, 0.5);
}
</style>