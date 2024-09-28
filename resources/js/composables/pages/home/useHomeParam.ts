import { Ref, ref } from 'vue'
import { Record } from '@/types/pages/home'
import axios from 'axios'
import { constant } from './constant'

export const useHomeParam = () => {
  const records: Ref<Record[]> = ref([
  ])

  const mounted = async () => {
    const response = await axios.get(constant.index)
    records.value = response.data.map((record: any) => ({
      id: record.record_id,
      name: record.record_name,
      imagePath: record.image_path ?? 'https://placehold.jp/150x150.png',
      evaluation: record.self_evaluation,
      description: record.description
    }));
  }

  return {
    records,
    mounted
  }
}