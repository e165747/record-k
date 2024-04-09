<script setup lang="ts">
import { ref } from 'vue';

const count = ref(0);

const addCount = () => {
  count.value = count.value + 1;
};
</script>

<template>
  <h2>Counter</h2>
  <p class="text-red">Count:{{ count }}</p>
  <button @click="addCount">Add</button>
</template>