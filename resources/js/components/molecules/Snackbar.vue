<template>
      <v-snackbar
      v-model="localSnackbar"
    >
      {{ text }}

      <template v-slot:actions>
        <v-btn
          color="pink"
          variant="text"
          @click="close"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
</template>
<script setup lang="ts">
import { ref, watch } from 'vue'
const props = defineProps<{
  snackbar: boolean,
  text: string
}>()
const emit = defineEmits(['update:snackbar'])
const localSnackbar = ref(props.snackbar)

watch(() => props.snackbar, (value) => {
  localSnackbar.value = value
})

const close = () => {
  localSnackbar.value = false
  emit('update:snackbar', false)
}

</script>