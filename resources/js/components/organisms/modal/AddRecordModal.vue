<template>
    <v-dialog>
      <template v-slot:activator="{ props }">
        <AddButton icon v-bind="props">
          <v-icon>mdi-record-circle</v-icon>
        </AddButton>
      </template>
      <template v-slot="{ isActive }">
      <v-card>
        <v-card-title>
          <span class="headline">New Record<v-icon>mdi-record-circle</v-icon></span>
        </v-card-title>
        <v-card-text>
          <!-- フォームやその他のコンテンツをここに追加 -->
          <v-text-field v-model="record.name" maxlength="100" :errorMessages="error.name" label="レコード名" />
          <v-text-field v-model="record.description" maxlength="200" label="レコードの説明" />
          <v-autocomplete
            v-model="record.authorId"
            :items="authorList"
            item-title="name"
            item-value="id"
            label="アーティスト名"
            :errorMessages="error.author_id"
            >
          </v-autocomplete>
          <v-checkbox
            v-model="record.isPossession"
            :label="`所持している`"
          ></v-checkbox>
          <v-text-field v-model="record.memo" maxlength="255" label="メモ" />
          <RatingStar :modelValue="record.evaluation" @update:modelValue="(newValue: number) => record.evaluation = newValue"/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="isActive.value = false">キャンセル</v-btn>
          <v-btn color="blue darken-1" @click="async () => {
            await save(isActive)
            // isActive.value = false
          }">保存</v-btn>
        </v-card-actions>
      </v-card>
      </template>
    </v-dialog>
</template>
<script setup lang="ts">
import AddButton from '@/components/atoms/buttons/AddButton.vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Record } from '@/types/pages/home';
import axios from 'axios';
import { ref, Ref, computed } from 'vue'
import { urls } from '@/composables/pages/home/constant';
import { constant } from '@/store/home/constant';

const emit = defineEmits(['after-store'])

const initialRecord: Record = {
  id: 0,
  authorId: 0,
  name: '',
  description: '',
  evaluation: 0,
  imagePath: '',
  isPossession: false,
  purchaseDate: '',
  memo: ''
}
const record: Ref<Record> = ref({
  id: 0,
  authorId: 0,
  name: '',
  description: '',
  evaluation: 0,
  imagePath: '',
  isPossession: false,
  purchaseDate: '',
  memo: ''
})

const authorList = computed(() => {
  return Object.entries(constant.AUTHOR_LIST).map(([id, name]) => ({ id: Number(id), name }))
})

const error = ref({
  name: '',
  author_id: '',
})

const save = async (isActive: Ref<boolean>) => {
  try {
    await axios.post(urls.store, {
      record_name: record.value.name,
      author_id: record.value.authorId,
      description: record.value.description,
      self_evaluation: record.value.evaluation,
      is_possession: record.value.isPossession,
      memo: record.value.memo,
    })
    record.value = initialRecord
    isActive.value = false
    emit('after-store')
  } catch (e: any) {
    error.value.name = e.response.data.errors['record_name']
  }
}
</script>