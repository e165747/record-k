<!-- 横に広く表示 -->
<script setup lang="ts">
import RatingStar from '@/components/molecules/RatingStar.vue';
import Delete from '@/components/atoms/buttons/Delete.vue';
import Detail from '@/components/atoms/buttons/Detail.vue';
import Caution from '../modal/share/Caution.vue';
import EditArtistModal from '@/components/organisms/modal/artists/EditArtistModal.vue';
import { useDialog } from '@/composables/pages/share/useDialog';
import { Artist } from '@/types/pages/artist';
import { useArtists } from '@/composables/pages/artists/useArtists';

const { detailData, recordData, getRecordsByAuthorId } = useArtists()
const props = defineProps<{
  artists: Artist[]
}>()
const { dialog, openDialog } = useDialog()
const { dialog: detailDialog, openDialog: openDetail, closeDialog: closeDetail } = useDialog()

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
                <Delete size=25 @delete="async () => {
                  detailData = artist
                  await getRecordsByAuthorId(artist.authorId)
                  openDialog()
                }" />
              </div>
            </v-row>
          </div>
        </div>
      </v-col>
    </v-row>
    <v-dialog key="detail" v-model="detailDialog">
      <EditArtistModal
        :data="detailData"
        @after-store="() => {
          closeDetail()
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
        <div>アーティスト名</div>
        <h3>{{ detailData.authorName }}</h3>
        <img style="height:150px; width:150px" :src="detailData.authorImage" />
        <div>詳細</div>
        <h3>{{ detailData.description }}</h3>
        <!-- 紐づくレコードを全て表示させる -->
         <h4>以下の作品も全て削除されます。</h4>
         <div v-for="record in recordData" :key="record.id">
           <div>{{ record.name }}</div>
         </div>
      </template>
    </Caution>
    </v-dialog>
  </v-container>
</template>