import { Ref, ref } from 'vue'
import { Record } from '@/types/pages/home'
import axios from 'axios'
import { constant } from './constant'

export const useHomeParam = () => {
  const records: Ref<Record[]> = ref([
  ])

  const mounted = async () => {
    getAllRecord()
  }

  const getAllRecord = async () => {
    const response = await axios.get(constant.index)
    records.value = response.data.map((record: any) => ({
      id: record.record_id,
      name: record.record_name,
      imagePath: record.image_path ?? 'https://placehold.jp/150x150.png',
      evaluation: parseFloat(record.self_evaluation),
      description: record.description,
      isPossession: record.is_possession,
      memo: record.memo,
    }));
  }

  // レコードの更新処理
  const update = async (record: Record) => {
    await axios.put(constant.update(record.id), {
      record_name: record.name,
      description: record.description,
      self_evaluation: record.evaluation,
      is_possession: record.isPossession,
      memo: record.memo,
    })
    getAllRecord()
  }

  const store = async (record: Record) => {
    await axios.post(constant.store, {
      record_name: record.name,
      description: record.description,
      self_evaluation: record.evaluation,
      is_possession: record.isPossession,
      memo: record.memo,
    })
    getAllRecord()
  }

  const deleteRecord = async (record: Record) => {
    await axios.delete(constant.delete(record.id))
    getAllRecord()
  }

  const getDetail = async (id: number) => {
    await axios.get(constant.getDetail(id))
  }

  return {
    records,
    mounted,
    getAllRecord,
    update,
    store,
  }
}