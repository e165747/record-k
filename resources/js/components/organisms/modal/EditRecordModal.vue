<template>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Record<v-icon>mdi-record-circle</v-icon></span>
        </v-card-title>
        <v-card-text>
          <!-- フォームやその他のコンテンツをここに追加 -->
           <v-row>
            <!-- <v-col md="9" style="width:70%; padding:8px"> -->
            <v-col md="9" style="padding:8px">
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
            </v-col>
            <!-- <div style="width:30%; padding:8px; text-align: right;"> -->
            <v-col md="3" style="padding:8px;">
                <div style="width:100%;  text-align: end;">
                  <img v-show="!isPreview" style="height:150px; width:150px" :src="record.imagePath"/>
                  <canvas v-show="isPreview" id="edit-img" width="150" height="150"></canvas>
                </div>
              <v-file-input v-model="jacketImg" accept="image/*" label="ジャケット写真選択" @change="previewImage"></v-file-input>
            </v-col>
           </v-row>
          <v-checkbox
            v-model="record.isPossession"
            :label="`所持している`"
          ></v-checkbox>
          <v-text-field v-model="record.memo" maxlength="255" label="メモ" />
          <RatingStar :modelValue="record.evaluation" @update:modelValue="(newValue: number) => record.evaluation = newValue"/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="$emit('close')">キャンセル</v-btn>
          <v-btn color="blue darken-1" @click="async () => {
            await save()
          }">保存</v-btn>
        </v-card-actions>
      </v-card>
</template>
<script setup lang="ts">
import { defineProps, defineEmits, onMounted, watch } from 'vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Record } from '@/types/pages/home';
import axios from 'axios';
import { ref, Ref, computed } from 'vue'
import { urls } from '@/composables/pages/home/constant';
import { constant } from '@/store/home/constant';

const dataProps = defineProps<{
  data: Record
}>()

const emit = defineEmits(['after-store', 'close'])

watch(() => dataProps.data, (newVal) => {
  record.value = { ...newVal }
})

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
const record: Ref<Record> = ref(dataProps.data)

const jacketImg = ref<File | null>(null);
// 画像選択時のプレビュー表示
const isPreview = ref(false);

const authorList = computed(() => {
  return Object.entries(constant.AUTHOR_LIST).map(([id, name]) => ({ id: Number(id), name }))
})

const error = ref({
  name: '',
  author_id: '',
})

const save = async () => {
  try {
    await axios.put(urls.update(record.value.id), {
      record_name: record.value.name,
      description: record.value.description,
      self_evaluation: record.value.evaluation,
      is_possession: record.value.isPossession,
      memo: record.value.memo,
    })
    record.value = initialRecord;
    emit('close');
    emit('after-store');
  } catch (e: any) {
    error.value.name = e.response.data.errors['record_name'];
  }
};

const previewImage = async () => {
  if (jacketImg.value) {
    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.onload = () => {
        const canvas = document.getElementById('edit-img') as HTMLCanvasElement;
        const ctx = canvas.getContext('2d');
        if (ctx) {
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        }
      };
      img.src = e.target?.result as string;
    };
    reader.readAsDataURL(jacketImg.value);
    isPreview.value = true;
    await uploadImage();
  }
};

const uploadImage = async () => {
  const formData = new FormData();
  if (jacketImg.value) {
    formData.append('jacket_img', jacketImg.value);
  }

  const response = await axios.post(urls.upsertImage(record.value.id), formData);
  // ファイル名を取得
  const fileName = response.data.image_path;
  if (fileName) {
    record.value.imagePath = fileName
    emit('after-store');
  }
}
</script>