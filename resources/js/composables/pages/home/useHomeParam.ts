import { Ref, ref } from 'vue'
// import { Record } from '~//types/pages/home'
import { Record } from '@/types/pages/home'

export const useHomeParam = () => {
  const records: Ref<Record[]> = ref([
    {
      id: 1,
      name: 'レコード1',
      imagePath: 'https://placehold.jp/150x150.png',
      evaluation: 3
    },
    {
      id: 2,
      name: 'レコード2',
      imagePath: 'https://placehold.jp/150x150.png',
      evaluation: 5
    },
    {
      id: 3,
      name: 'レコード3',
      imagePath: 'https://placehold.jp/150x150.png',
      evaluation: 4
    }
  ])

  return {
    records
  }
}