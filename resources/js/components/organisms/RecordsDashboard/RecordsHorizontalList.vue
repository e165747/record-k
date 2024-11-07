<!-- 横に広く表示 -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import { Record } from '@/types/pages/home'
const props = defineProps<{
  records: Record[]
}>()

</script>
<template>
  <v-container>
    <v-row>
      <v-col md="3" v-for="record in props.records" :key="record.id">
        <div class="p-2">
          <img :src="record.imagePath" />
          <div >
            <span>{{ record.name }}</span>
            <v-row style="width:150px" justify="space-between" no-gutters>
              <div>
                <RatingStar :modelValue="record.evaluation" :is-show-full="false" />
              </div>
              <div>
                <Detail :size="25" @detail="() => { }" />
                <Delete :size="25" @delete="() => { }" />
              </div>
            </v-row>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>