<script setup lang="ts">
import { useHomeParam } from '@/composables/pages/home/useHomeParam'
import { onMounted } from 'vue'
import RecordsDashboardHorizontalList from '@/components/organisms/RecordsDashboard/RecordsHorizontalList.vue'
import RecordsVerticalList from '@/components/organisms/RecordsDashboard/RecordsVerticalList.vue';
import LayoutSwitcher from '@/components/molecules/LayoutSwitcher.vue';
import { useLayoutSwitch } from '@/composables/pages/share/useLayoutSwitch';

const { records, mounted } = useHomeParam()
const { horizontal, changeHorizontal, changeVertical } = useLayoutSwitch()

onMounted(async () => {
  await mounted()
})
</script>

<template>
  <v-container>
    <v-container :style="{ display: 'flex', justifyContent: 'flex-end' }">
      <LayoutSwitcher :horizontal="horizontal" @change-horizontal="changeHorizontal" @change-vertical="changeVertical" />
    </v-container>
    <RecordsDashboardHorizontalList v-if="horizontal" :records="records" />
    <RecordsVerticalList v-if="!horizontal" :records="records" />
  </v-container>
</template>