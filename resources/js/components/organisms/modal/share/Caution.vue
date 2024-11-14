<!-- 警告モーダル -->
<template>
  <v-card>
    <v-card-title class="warning">
      <v-text class="warning">{{ props.title }}<v-icon color="warning">mdi-alert</v-icon></v-text>
    </v-card-title>
    <v-card-text>
      <div class="mb-3">
        {{ props.message }}
      </div>
      <slot name="content"></slot>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" @click="closeDialog">キャンセル</v-btn>
      <v-btn color="blue darken-1" @click="async () => {
        await execute()
        closeDialog()
      }">実行</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps<{
  title: string,
  message: string,
}>()

const emit = defineEmits(['execute', 'update:isDialogActive']);

const closeDialog = () => {
  emit('update:isDialogActive', false);
};

const execute = async () => {
  await emit('execute')
}

</script>
<style scoped>
.warning {
  color: var(--v-theme-warning);
}
</style>