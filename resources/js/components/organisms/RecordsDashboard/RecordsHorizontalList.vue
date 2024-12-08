<!-- 横に広く表示 -->
<script setup lang="ts">
import { ref } from 'vue'
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import EditRecordModal from '../modal/EditRecordModal.vue';
import { Record } from '@/types/pages/home'
import { useDialog } from '@/composables/pages/share/useDialog';
import { constant } from '@/store/home/constant';
const props = defineProps<{
  records: Record[]
}>()
const { dialog, openDialog } = useDialog()
const { dialog: detailDialog, openDialog: openDetail } = useDialog()
const detailData = ref<Record>({
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

const emits = defineEmits(['delete', 'reload'])

const setData = (record: Record) => {
  detailData.value = record
}

</script>
<template>
  <v-container>
    <v-row>
      <v-col md="3" v-for="record in props.records" :key="record.id">
        <div class="p-2">
          <img style="height:150px; width:150px" :src="record.imagePath" />
          <div >
            <span>{{ record.name }}</span>
            <v-row style="width:150px" justify="space-between" no-gutters>
              <div>
                <RatingStar :modelValue="record.evaluation" :is-show-full="false" />
              </div>
              <div>
                <Detail :size="25" @detail="() => {
                  setData(record)
                  openDetail()
                }" />
                <Delete size=25 @delete="() => {
                  setData(record)
                  openDialog()
                }" />
              </div>
            </v-row>
          </div>
        </div>
      </v-col>
    </v-row>
    <v-dialog key="detail" v-model="detailDialog">
      <EditRecordModal
        :data="detailData"
        @after-store="() => {
          emits('reload')
        }"
        @close="detailDialog = false"
      />
    </v-dialog>
    <v-dialog v-model="dialog">
      <Caution
        :is-open="dialog"
        :title="'削除確認'"
        :message="'以下の項目を本当に削除しますか？'"
        @update:isDialogActive="dialog = $event"
        @execute="() => { emits('delete', detailData) }"
      >
      <template #content>
        <div>レコード名</div>
        <h3>{{ detailData.name }}</h3>
        <img style="height:150px; width:150px" :src="detailData.imagePath" />
        <div>アーティスト</div>
        <h3>{{ detailData.authorId !== undefined ? constant.AUTHOR_LIST[detailData.authorId] : '' }}</h3>
        <div>詳細</div>
        <h3>{{ detailData.description }}</h3>
      </template>
    </Caution>
    </v-dialog>
  </v-container>
</template>