<template>
    <v-dialog>
      <template v-slot:activator="{ props }">
        <AddButton icon v-bind="props"/>
      </template>
      <template v-slot="{ isActive }">
      <v-card>
        <v-card-title>
          <span class="headline">New Record</span>
        </v-card-title>
        <v-card-text>
          <!-- フォームやその他のコンテンツをここに追加 -->
          <v-text-field v-model="record.name" maxlength="100" :errorMessages="error.name" label="レコード名" />
          <v-text-field v-model="record.description" maxlength="200" label="レコードの説明" />
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
import AddButton from '@/components/atoms/AddButton.vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Record } from '@/types/pages/home';
import axios from 'axios';
import { ref, Ref } from 'vue'
import { constant } from '@/composables/pages/home/constant';

const emit = defineEmits(['after-store'])

const initialRecord: Record = {
  id: 0,
  name: '',
  description: '',
  evaluation: 0,
  imagePath: '',
  isPossession: false,
  memo: ''
}
const record: Ref<Record> = ref({
  id: 0,
  name: '',
  description: '',
  evaluation: 0,
  imagePath: '',
  isPossession: false,
  memo: ''
})

const error = ref({
  name: '',
})

const save = async (isActive: Ref<boolean>) => {
  try {
    await axios.post(constant.store, {
      record_name: record.value.name,
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