<template>
  <!-- 削除ボタン -->
  <v-btn :size="props.size" @click="$emit('delete')" color="gray"><v-icon>{{ 'mdi-delete' }}</v-icon></v-btn>
</template>
<script setup lang="ts">
import { defineProps, withDefaults } from 'vue'
const props = withDefaults(defineProps<{
  size?: string | number
}>(), {
  size: ''
});
</script>