<!-- 縦に並べて情報量を多く -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import { Artist } from '@/types/pages/artist';
import { useDialog } from '@/composables/pages/share/useDialog';
import EditArtistModal from '@/components/organisms/modal/artists/EditArtistModal.vue';
import { useArtists } from '@/composables/pages/artists/useArtists';

const { detailData } = useArtists()

const props = defineProps<{
  artists: Artist[]
}>()
const emits = defineEmits(['update', 'delete', 'reload'])
const { dialog: deleteDialog, openDialog: openDelete } = useDialog()
const { dialog: detailDialog, openDialog: openDetail } = useDialog()

// 更新する
const handleRatingChange = async (artist: Artist, newRating: number) => {
  const newArtist = { ...artist, selfEvaluation: newRating }
  emits('update', newArtist)
}

</script>
<template>
  <v-container>
    <v-row v-for="artist in props.artists" :key="artist.authorId">
      <v-col cols="12" class="h-100">
        <v-card class="pa-2 d-flex align-center">
          <div style="max-height:150px;max-width:150px">
            <v-img height="150" width="150" :src="artist.authorImage" />
          </div>
          <div class="h-100 px-2 d-flex flex-column align-start">
            <!-- レコード名 -->
            {{ artist.authorName }}
            <div class="text-muted">
              {{ artist.knowDate }}
            </div>
            <!-- 説明 -->
            <div class="text-muted">
              {{ artist.description }}
            </div>
          </div>
          <div class="ml-auto">
            <!-- 自己評価 -->
            <RatingStar :modelValue="artist.selfEvaluation" @update:modelValue="(newRating: number) => handleRatingChange(artist, newRating)"/>
          </div>
          <v-card-actions>
            <Detail @detail="() => {
              detailData = artist
              openDetail()
            }" />
            <Delete @delete="() => {
              detailData = artist
              openDelete()
            }" />
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog key="detail" v-model="detailDialog">
      <EditArtistModal
        :data="detailData"
        @after-store="() => {
          emits('reload')
        }"
        @close="detailDialog = false"
      />
    </v-dialog>
    <v-dialog key="delete" v-model="deleteDialog">
      <Caution
        :title="'削除確認'"
        :message="'以下の項目を本当に削除しますか？'"
        @update:isDialogActive="deleteDialog = $event"
        @execute="() => { emits('delete', detailData) }"
      >
      <template #content>
        <div>アーティスト名</div>
        <h3>{{ detailData.authorName }}</h3>
        <div>詳細</div>
        <h3>{{ detailData.description }}</h3>
        <img :src="detailData.authorImage" />
        <!-- TODO 紐づくレコードを全て表示させる -->
         <h4>以下の作品も全て削除されます。</h4>
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