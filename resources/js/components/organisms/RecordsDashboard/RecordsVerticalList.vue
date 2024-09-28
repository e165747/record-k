<!-- 縦に並べて情報量を多く -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Record } from '@/types/pages/home'
const props = defineProps<{
  records: Record[]
}>()

</script>
<template>
  <v-container>
    <v-row v-for="record in props.records" :key="record.id">
      <v-col cols="12" class="h-100">
        <v-card class="pa-2 d-flex align-center">
          <img :src="record.imagePath" />
          <div class="h-100 px-2 d-flex flex-column align-start">
            <!-- レコード名 -->
            {{ record.name }}
            <!-- メモ -->
            <div class="text-muted">
              {{ record.description }}
            </div>
          </div>
          <div class="ml-auto">
            <!-- 自己評価 -->
            <RatingStar :modelValue="record.evaluation" />
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<style scoped>
.text-muted {
  font-size: .8rem;
  opacity: 0.6;
}
</style>