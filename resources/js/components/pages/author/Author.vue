<script setup lang="ts">
import { onMounted } from 'vue'
import LayoutSwitcher from '@/components/molecules/LayoutSwitcher.vue';
import { useArtists } from '@/composables/pages/artists/useArtists';
import { useLayoutSwitch } from '@/composables/pages/share/useLayoutSwitch';
import ArtistsHorizontalList from '@/components/organisms/Artists/ArtistsHorizontalList.vue';
import ArtistsVerticalList from '@/components/organisms/Artists/ArtistsVerticalList.vue';
import AddArtistModal from '@/components/organisms/modal/artists/AddArtistModal.vue';

const { horizontal, changeHorizontal, changeVertical } = useLayoutSwitch()
const { artists, mounted, getAllArtist, update, deleteRecord } = useArtists()

onMounted(() => {
  mounted()
})

</script>

<template>
  <v-container>
    <v-container :style="{ display: 'flex', justifyContent: 'flex-end' }">
      <h2 class="mr-2">All Artists</h2>
      <v-spacer></v-spacer>
      <div class="mr-2"><AddArtistModal @after-store="getAllArtist"/></div>
      <LayoutSwitcher :horizontal="horizontal" @change-horizontal="changeHorizontal" @change-vertical="changeVertical" />
    </v-container>
    <ArtistsHorizontalList v-if="horizontal" :artists="artists" @update="update" @delete="deleteRecord" @reload="getAllArtist"/>
    <ArtistsVerticalList v-if="!horizontal" :artists="artists" @update="update" @delete="deleteRecord" @reload="getAllArtist"/>
  </v-container>

</template>