<template>
    <v-dialog>
      <template v-slot:activator="{ props }">
        <AddButton icon v-bind="props">
          <v-icon>mdi-robot</v-icon>
        </AddButton>
      </template>
      <template v-slot="{ isActive }">
      <v-card>
        <v-card-title>
          <span class="headline">Add New Record Use Ai<v-icon class="ml-2">mdi-robot</v-icon></span>
        </v-card-title>
        <v-card-text>
            <span class="text-body-2">アーティスト情報やレコード情報をもつPDFファイルをアップロードすることで，そのファイルをAIが自動で読み取りデータを追加することができます。※利用するファイルや記載方法によってうまく登録されない場合があります。追加したデータは自分で確認することをお勧めします。</span>
          <!-- フォームやその他のコンテンツをここに追加 -->
           <v-row class="mt-4">
            <v-col md="3" style="padding:8px;">
              <v-file-input v-model="filePath" accept="image/*" label="ジャケット写真選択"></v-file-input>
            </v-col>
           </v-row>
          <v-text-field v-model="inputData.prompt" maxlength="255" label="追加プロンプト" />
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
import { AiInputType } from '@/types/pages/home';
import axios from 'axios';
import { ref, Ref, computed } from 'vue'
import { urls } from '@/composables/pages/home/constant';
import { constant } from '@/store/home/constant';

const emit = defineEmits(['after-store'])

const initialInputData: AiInputType = {
  prompt: '',
  filePath: '',
}
const inputData: Ref<AiInputType> = ref({
  ...initialInputData,
})

const filePath = ref<File | null>(null);

const error = ref({
  filePath: '',
  prompt: '',
})

const save = async (isActive: Ref<boolean>) => {
  try {
    const formData = new FormData();
    formData.append('prompt', inputData.value.prompt);

    if (filePath.value) {
      formData.append('file_path', filePath.value);
    }

    const response = await axios.post(urls.inputAi, formData);
    console.log(response.data);

    inputData.value = initialInputData;
    isActive.value = false;
    // emit('after-store');
  } catch (e: any) {
    if (e.response.status === 422) {
      error.value.filePath = e.response.data.errors['file_path'];
      error.value.prompt = e.response.data.errors['prompt'];
    } else {
      console.error('Error:', e);
    }
  }
};

</script>