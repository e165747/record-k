<!--　追加ボタン -->
<template>
  <v-btn icon @click="$emit('add')" class="btn-left">
    <v-icon>{{ 'mdi-plus' }}</v-icon>
  </v-btn>
</template>