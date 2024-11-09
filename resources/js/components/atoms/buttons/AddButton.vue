<!--　追加ボタン -->
<template>
  <v-btn icon @click="$emit('add')" class="btn-left">
    <v-icon :size="20">{{ 'mdi-plus' }}</v-icon>
    <slot></slot>
  </v-btn>
</template>