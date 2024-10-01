<script setup lang="ts">
import { Props } from '@/types/molecules/Rating'

const props = withDefaults(
  defineProps<Props>(),
  {
    isShowFull: true,
    disabled: false,
    length: 5,
    size: 32,
    modelValue: 0,
    color: 'yellow',
    activeColor: 'yellow',
    hover: true,
    emptyIcon: 'mdi-star-outline',
    fullIcon: 'mdi-star',
    halfIcon: 'mdi-star-half'
    // レコードアイコンにしようと思ったけどわかりにくかったから一旦コメントアウト
    // emptyIcon: 'mdi-record-circle-outline',
    // fullIcon: 'mdi-record-circle',
    // halfIcon: 'mdi-record-circle-half'
  }
)
const emit = defineEmits(['update:modelValue'])

function handleRatingChange(newRating: string | number) {
  // newRatingがstringの場合は数値に変換
  if (typeof newRating === 'string') {
    newRating = parseInt(newRating)
  }
  emit('update:modelValue', newRating)
}
</script>
<template>
  <v-rating
    v-if="props.isShowFull"
    :readonly="props.disabled"
    :hover="props.hover"
    half-increments
    :length="props.length"
    :size="props.size"
    :model-value="props.modelValue"
    :color="props.color"
    :active-color="props.activeColor"
    :empty-icon="props.emptyIcon"
    :full-icon="props.fullIcon"
    :half-icon="props.halfIcon"
    @update:model-value="handleRatingChange"
  />
  <div v-else>
    <v-icon :color="props.color">{{ props.fullIcon }}</v-icon>
    {{ props.modelValue }}
  </div>
</template>