import { ref } from 'vue'

export function useDialog(initialValue = false) {
  const dialog = ref(initialValue)

  const openDialog = () => {
    dialog.value = true
  }

  const closeDialog = () => {
    dialog.value = false
  }

  return { dialog, openDialog, closeDialog }
}