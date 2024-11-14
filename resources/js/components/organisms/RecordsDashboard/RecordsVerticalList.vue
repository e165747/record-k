<!-- 縦に並べて情報量を多く -->
<script setup lang="ts">
import { ref } from 'vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import { Record } from '@/types/pages/home'
import { constant } from '@/store/home/constant';
import { useDialog } from '@/composables/pages/share/useDialog';

const props = defineProps<{
  records: Record[]
}>()
const emits = defineEmits(['update', 'delete'])
const { dialog, openDialog } = useDialog()

// 更新する
const handleRatingChange = (record: Record, newRating: number) => {
  const newRecord = { ...record, evaluation: newRating }
  emits('update', newRecord)
}

const deleteData = ref<Record>({
  id: 0,
  name: '',
  authorId: 0,
  description: '',
  imagePath: '',
  evaluation: 0,
  isPossession: false,
  memo: '',
  purchaseDate: ''
})

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
            <!-- 説明 -->
            <div class="text-muted">
              {{ constant.AUTHOR_LIST[record.authorId] }}
              {{ record.description }}
            </div>
          </div>
          <div class="ml-auto">
            <!-- 自己評価 -->
            <RatingStar :modelValue="record.evaluation" @update:modelValue="(newRating: number) => handleRatingChange(record, newRating)"/>
          </div>
          <v-card-actions>
            <Detail @detail="() => { }" />
            <Delete @delete="() => {
              deleteData = record
              openDialog()
            }" />
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog v-model="dialog">
      <Caution
        :is-open="dialog"
        :title="'削除確認'"
        :message="'以下の項目を本当に削除しますか？'"
        @update:isDialogActive="dialog = $event"
        @execute="() => { emits('delete', deleteData) }"
      >
      <template #content>
        <div>レコード名</div>
        <h3>{{ deleteData.name }}</h3>
        <div>アーティスト</div>
        <h3>{{ deleteData.authorId !== undefined ? constant.AUTHOR_LIST[deleteData.authorId] : '' }}</h3>
        <div>詳細</div>
        <h3>{{ deleteData.description }}</h3>
      </template>
    </Caution>
    </v-dialog>
  </v-container>
</template>
<style scoped>
.text-muted {
  font-size: .8rem;
  opacity: 0.6;
}
</style>