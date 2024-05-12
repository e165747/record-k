import { Ref, ref } from 'vue'
import { Record } from '@/types/pages/home'
import axios from 'axios'
import { constant } from './constant'

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

  const mounted = async () => {
    const response = await axios.get(constant.index)
    records.value = response.data.map((record: any) => ({
      id: record.record_id,
      name: record.record_name,
      imagePath: record.image_path ?? 'https://placehold.jp/150x150.png',
      evaluation: record.self_evaluation
    }));
  }

  return {
    records,
    mounted
  }
}