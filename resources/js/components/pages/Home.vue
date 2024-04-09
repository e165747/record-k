<script setup lang="ts">
import { useHomeParam } from '@/composables/pages/home/useHomeParam'

const { records } = useHomeParam()
</script>

<template>
  <h1 class="text-primary">Hello World</h1>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-4" v-for="record in records" :key="record.id">
        <div class="row p-2">
          <img :src="record.imagePath" />
          <span class="p-2">{{ record.name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>