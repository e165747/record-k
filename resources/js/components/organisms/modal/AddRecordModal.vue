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
                  <!-- <img style="text-align: right;" :src="'https://placehold.jp/150x150.png'"/> -->
                  <canvas id="jacket-img" width="150" height="150"></canvas>
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

const jacketImg = ref<File | null>(null);

const authorList = computed(() => {
  return Object.entries(constant.AUTHOR_LIST).map(([id, name]) => ({ id: Number(id), name }))
})

const error = ref({
  name: '',
  author_id: '',
})

const save = async (isActive: Ref<boolean>) => {
  try {
    const formData = new FormData();
    formData.append('record_name', record.value.name);
    formData.append('author_id', record.value.authorId?.toString() || '');
    formData.append('description', record.value.description);
    formData.append('self_evaluation', record.value.evaluation.toString());
    formData.append('is_possession', record.value.isPossession ? '1' : '0');
    formData.append('memo', record.value.memo);

    if (jacketImg.value) {
      formData.append('jacket_img', jacketImg.value);
    }

    await axios.post(urls.store, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    record.value = initialRecord;
    isActive.value = false;
    emit('after-store');
  } catch (e: any) {
    error.value.name = e.response.data.errors['record_name'];
  }
};

const previewImage = () => {
  if (jacketImg.value) {
    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.onload = () => {
        const canvas = document.getElementById('jacket-img') as HTMLCanvasElement;
        const ctx = canvas.getContext('2d');
        if (ctx) {
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        }
      };
      img.src = e.target?.result as string;
    };
    reader.readAsDataURL(jacketImg.value);
  }
};
</script>