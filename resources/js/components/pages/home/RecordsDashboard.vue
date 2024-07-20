<script setup lang="ts">
import { useHomeParam } from '@/composables/pages/home/useHomeParam'
import { onMounted } from 'vue'
import RecordsDashboardHorizontalList from '@/components/organisms/RecordsDashboard/RecordsHorizontalList.vue'
import RecordsVerticalList from '@/components/organisms/RecordsDashboard/RecordsVerticalList.vue';

const { records, mounted } = useHomeParam()

onMounted(async () => {
  await mounted()
})
</script>

<template>
  <v-container>
    <!-- <RecordsDashboardHorizontalList :records="records" /> -->
    <RecordsVerticalList :records="records" />
  </v-container>
</template>