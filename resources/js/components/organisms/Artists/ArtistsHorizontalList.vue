<!-- 横に広く表示 -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import { useDialog } from '@/composables/pages/share/useDialog';
import { Artist } from '@/types/pages/artist';
import { useArtists } from '@/composables/pages/artists/useArtists';

const { detailData } = useArtists()
const props = defineProps<{
  artists: Artist[]
}>()
const { dialog, openDialog } = useDialog()
const { dialog: detailDialog, openDialog: openDetail } = useDialog()

const emits = defineEmits(['delete', 'reload'])

</script>
<template>
  <v-container>
    <v-row>
      <v-col md="3" v-for="artist in props.artists" :key="artist.authorId">
        <div class="p-2">
          <img style="height:150px; width:150px" :src="artist.authorImage" />
          <div >
            <span>{{ artist.authorName }}</span>
            <v-row style="width:150px" justify="space-between" no-gutters>
              <div>
                <RatingStar :modelValue="artist.selfEvaluation" :is-show-full="false" />
              </div>
              <div>
                <Detail :size="25" @detail="() => {
                  detailData = artist
                  openDetail()
                }" />
                <Delete size=25 @delete="() => {
                  detailData = artist
                  openDialog()
                }" />
              </div>
            </v-row>
          </div>
        </div>
      </v-col>
    </v-row>
    <v-dialog key="detail" v-model="detailDialog">
      <!-- <EditRecordModal
        :data="detailData"
        @after-store="() => {
          detailDialog = false
          emits('reload')
        }"
        @close="detailDialog = false"
      /> -->
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