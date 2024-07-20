<script setup lang="ts">
import { Record } from '@/types/pages/home'
const props = defineProps<{
  records: Record[]
}>()

</script>
<template>
  <v-container>
    <v-row v-for="record in props.records" :key="record.id">
      <div class="pa-2 d-flex align-center">
        <img :src="record.imagePath" />
        <div class="px-2">
          <!-- TODO 所持状態 -->
          {{ record.name }}
          <!-- TODO 自己評価 -->
          <!-- TODO メモ -->
        </div>
      </div>
    </v-row>
  </v-container>
</template>