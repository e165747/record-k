import { Ref, ref } from 'vue'
import axios from 'axios'
import { urls } from './constant'
import { Artist } from '@/types/pages/artist'


export const useArtists = () => {
  const artists: Ref<Artist[]> = ref([
  ])

  const detailData = ref<Artist>({
    authorId: 0,
    userId: 0,
    authorName: '',
    authorImage: '',
    selfEvaluation: 0,
    description: '',
    knowDate: '',
    memo: '',
    purchaseDate: '',
  })

  const mounted = async () => {
    getAllArtist()
  }

  const getAllArtist = async () => {
    const response = await axios.get(urls.index)
    artists.value = response.data.map((artist: any) => ({
      authorId: artist.author_id,
      name: artist.author_name,
      authorImage: artist.author_image ?? 'https://placehold.jp/150x150.png',
      selfEvaluation: parseFloat(artist.self_evaluation),
      description: artist.description,
      memo: artist.memo,
    }));
  }

  // レコードの更新処理
  const update = async (artist: Artist) => {
    await axios.put(urls.update(artist.authorId), {
      author_name: artist.authorName,
      description: artist.description,
      self_evaluation: artist.selfEvaluation,
      memo: artist.memo,
    })
  }

  const store = async (artist: Artist) => {
    await axios.post(urls.store, {
      author_name: artist.authorName,
      description: artist.description,
      self_evaluation: artist.selfEvaluation,
      memo: artist.memo,
    })
  }

  const deleteRecord = async (record: Artist) => {
    await axios.delete(urls.delete(record.authorId))
  }

  const getDetail = async (id: number) => {
    await axios.get(urls.getDetail(id))
  }

  return {
    artists,
    detailData,
    mounted,
    getAllArtist,
    update,
    store,
    deleteRecord,
  }
}