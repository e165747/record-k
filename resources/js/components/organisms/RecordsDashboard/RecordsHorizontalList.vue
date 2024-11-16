<!-- 横に広く表示 -->
<script setup lang="ts">
import { ref } from 'vue'
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import { Record } from '@/types/pages/home'
import { useDialog } from '@/composables/pages/share/useDialog';
import { constant } from '@/store/home/constant';
const props = defineProps<{
  records: Record[]
}>()
const { dialog, openDialog } = useDialog()
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

const emits = defineEmits(['delete'])


</script>
<template>
  <v-container>
    <v-row>
      <v-col md="3" v-for="record in props.records" :key="record.id">
        <div class="p-2">
          <v-img width="150" :src="record.imagePath" />
          <div >
            <span>{{ record.name }}</span>
            <v-row style="width:150px" justify="space-between" no-gutters>
              <div>
                <RatingStar :modelValue="record.evaluation" :is-show-full="false" />
              </div>
              <div>
                <Detail :size="25" @detail="() => { }" />
                <Delete size=25 @delete="() => {
                  deleteData = record
                  openDialog()
                }" />
              </div>
            </v-row>
          </div>
        </div>
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