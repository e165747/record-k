<script setup lang="ts">
import LayoutSwitcher from '@/components/molecules/LayoutSwitcher.vue';
import { useLayoutSwitch } from '@/composables/pages/share/useLayoutSwitch';

const { horizontal, changeHorizontal, changeVertical } = useLayoutSwitch()
</script>

<template>
  <v-container>
    <v-container :style="{ display: 'flex', justifyContent: 'flex-end' }">
      <h2 class="mr-2">All Artists</h2>
      <v-spacer></v-spacer>
      <LayoutSwitcher :horizontal="horizontal" @change-horizontal="changeHorizontal" @change-vertical="changeVertical" />
    </v-container>
  </v-container>

</template>