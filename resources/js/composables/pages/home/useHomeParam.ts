import { Ref, ref } from 'vue'
import { Record } from '@/types/pages/home'
import axios from 'axios'
import { urls } from './constant'
import { constant } from '@/store/home/constant'


export const useHomeParam = () => {
  const records: Ref<Record[]> = ref([
  ])

  const mounted = async () => {
    getAllRecord()
    getAuthors()
  }

  const getAuthors = async () => {
    const response = await axios.get(urls.getAuthors)
    constant.AUTHOR_LIST = response.data
  }

  const getAllRecord = async () => {
    const response = await axios.get(urls.index)
    records.value = response.data.map((record: any) => ({
      id: record.record_id,
      authorId: record.author_id,
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
    await axios.put(urls.update(record.id), {
      record_name: record.name,
      description: record.description,
      self_evaluation: record.evaluation,
      is_possession: record.isPossession,
      memo: record.memo,
    })
    getAllRecord()
  }

  const store = async (record: Record) => {
    await axios.post(urls.store, {
      record_name: record.name,
      description: record.description,
      self_evaluation: record.evaluation,
      is_possession: record.isPossession,
      memo: record.memo,
    })
    getAllRecord()
  }

  const deleteRecord = async (record: Record) => {
    await axios.delete(urls.delete(record.id))
    getAllRecord()
  }

  const getDetail = async (id: number) => {
    await axios.get(urls.getDetail(id))
  }

  return {
    records,
    mounted,
    getAllRecord,
    update,
    store,
    deleteRecord,
  }
}