<!-- 横に広く表示 -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Record } from '@/types/pages/home'
const props = defineProps<{
  records: Record[]
}>()

</script>
<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="3" v-for="record in props.records" :key="record.id">
        <div class="p-2">
          <img :src="record.imagePath" />
          <div >
            {{ record.name }}
            <RatingStar :modelValue="record.evaluation" :is-show-full="false" />
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>