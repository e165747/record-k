<template>
    <v-dialog>
      <template v-slot:activator="{ props }">
        <AddButton icon v-bind="props">
          <v-icon>mdi-guitar-acoustic</v-icon>
        </AddButton>
      </template>
      <template v-slot="{ isActive }">
      <v-card>
        <v-card-title>
          <span class="headline">New Artist<v-icon> mdi-guitar-acoustic</v-icon></span>
        </v-card-title>
        <v-card-text>
          <!-- フォームやその他のコンテンツをここに追加 -->
           <v-row>
            <v-col md="9" style="padding:8px">
              <v-text-field v-model="artist.authorName" maxlength="100" :errorMessages="error.authorName" label="アーティスト名" />
              <v-text-field v-model="artist.description" maxlength="200" label="アーティストについて説明" />
            </v-col>
            <v-col md="3" style="padding:8px;">
                <div style="width:100%;  text-align: end;">
                  <!-- <img style="text-align: right;" :src="'https://placehold.jp/150x150.png'"/> -->
                  <canvas id="jacket-img" width="150" height="150"></canvas>
                </div>
              <v-file-input v-model="authorImg" accept="image/*" label="ジャケット写真選択" @change="previewImage"></v-file-input>
            </v-col>
           </v-row>
          <v-text-field v-model="artist.memo" maxlength="255" label="メモ" />
          <RatingStar :modelValue="artist.selfEvaluation" @update:modelValue="(newValue: number) => artist.selfEvaluation = newValue"/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="isActive.value = false">キャンセル</v-btn>
          <v-btn color="blue darken-1" @click="async () => {
            await save(isActive)
          }">保存</v-btn>
        </v-card-actions>
      </v-card>
      </template>
    </v-dialog>
</template>
<script setup lang="ts">
import AddButton from '@/components/atoms/buttons/AddButton.vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Artist } from '@/types/pages/artist';
import { ref, Ref } from 'vue'
import { useArtists } from '@/composables/pages/artists/useArtists';

const emit = defineEmits(['after-store'])
const { storeForm } = useArtists()

const initialArtist: Artist = {
  userId: 0,
  authorId: 0,
  authorImage: '',
  authorName: '',
  description: '',
  knowDate: '',
  selfEvaluation: 0,
  memo: ''
}
const artist: Ref<Artist> = ref({
  ...initialArtist
})

const authorImg = ref<File | null>(null);

const error = ref({
  authorName: '',
})

const save = async (isActive: Ref<boolean>) => {
  try {
    await storeForm(artist.value, authorImg.value);
    artist.value = initialArtist;
    isActive.value = false;
    emit('after-store');
  } catch (e: any) {
    error.value.authorName = e.response.data.errors['author_name'];
  }
};

const previewImage = () => {
  if (authorImg.value) {
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
    reader.readAsDataURL(authorImg.value);
  }
};
</script>