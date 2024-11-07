<template>
  <!-- 詳細ボタン -->
  <v-btn :size="props.size" @click="$emit('detail')" color="gray"><v-icon>{{ 'mdi-information' }}</v-icon></v-btn>
</template>
<script setup lang="ts">
import { defineProps, withDefaults } from 'vue'
const props = withDefaults(defineProps<{
  size?: string | number
}>(), {
  size: ''
});
</script>