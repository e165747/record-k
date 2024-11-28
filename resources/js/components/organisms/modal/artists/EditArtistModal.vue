<template>
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
                  <img v-show="!isPreview" style="height:150px; width:150px" :src="artist.authorImage"/>
                  <canvas v-show="isPreview" id="edit-img" width="150" height="150"></canvas>
                </div>
              <v-file-input v-model="authorImg" accept="image/*" label="ジャケット写真選択" @change="previewImage"></v-file-input>
            </v-col>
           </v-row>
          <v-text-field v-model="artist.memo" maxlength="255" label="メモ" />
          <RatingStar :modelValue="artist.selfEvaluation" @update:modelValue="(newValue: number) => artist.selfEvaluation = newValue"/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="$emit('close')">キャンセル</v-btn>
          <v-btn color="blue darken-1" @click="async () => {
            await update(artist, () => $emit('after-store'))
          }">保存</v-btn>
        </v-card-actions>
      </v-card>
</template>
<script setup lang="ts">
import { defineProps, defineEmits, watch } from 'vue';
import RatingStar from '@/components/molecules/RatingStar.vue';
import { Artist } from '@/types/pages/artist';
import { ref, Ref } from 'vue'
import { useArtists } from '@/composables/pages/artists/useArtists';

const props = defineProps<{
  data: Artist
}>()
const emit = defineEmits(['after-store', 'close'])
const { uploadImage, update } = useArtists()

watch(() => props.data, (newVal) => {
  artist.value = { ...newVal }
})

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
const artist: Ref<Artist> = ref(
  props.data
)

const authorImg = ref<File | null>(null);
// 画像選択時のプレビュー表示
const isPreview = ref(false);

const error = ref({
  authorName: '',
})

const previewImage = async () => {
  if (authorImg.value) {
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
    reader.readAsDataURL(authorImg.value);
    isPreview.value = true;
    await uploadImage(artist.value, authorImg.value, (url: string) => {
      console.log(url);
      artist.value.authorImage = url;
      emit('after-store');
    });
  }
};
</script>