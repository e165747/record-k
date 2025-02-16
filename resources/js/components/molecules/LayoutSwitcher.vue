<!-- 縦横表示切り替えスイッチボタン -->
<template>
  <v-btn icon @click="$emit('change-horizontal')" class="btn-left">
    <v-icon :disabled="!horizontal">{{ 'mdi-view-grid' }}</v-icon>
  </v-btn>
  <v-btn icon @click="$emit('change-vertical')" class="btn-right">
    <v-icon :disabled="horizontal">{{ 'mdi-view-list' }}</v-icon>
  </v-btn>
</template>

<script setup lang="ts">
const props = defineProps<{
  horizontal: boolean
}>()
const emits = defineEmits(['change-horizontal', 'change-vertical'])
</script>
<style scoped>
.btn-group {
  display: flex;
  border: 1px solid #ccc;
  border-radius: 8px;
  overflow: hidden;
}

.btn-left {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.btn-right {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
</style>