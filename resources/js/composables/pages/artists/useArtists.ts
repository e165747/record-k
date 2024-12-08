import { Ref, ref } from 'vue'
import axios from 'axios'
import { urls } from './constant'
import { Artist } from '@/types/pages/artist'
import { Record } from '@/types/pages/home'


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
  })

  const recordData = ref<Record[]>([])

  const mounted = async () => {
    getAllArtist()
  }

  const getAllArtist = async () => {
    const response = await axios.get(urls.index)
    artists.value = response.data.map((ats: any) => ({
      authorId: ats.author_id,
      authorName: ats.author_name,
      authorImage: ats.author_image ?? 'https://placehold.jp/150x150.png',
      selfEvaluation: parseFloat(ats.self_evaluation),
      description: ats.description,
      memo: ats.memo,
      knowDate: ats.know_date,
    }));
  }

  // アーティストの更新処理
  const update = async (artist: Artist, callback?: () => void) => {
    await axios.put(urls.update(artist.authorId), {
      author_name: artist.authorName,
      description: artist.description,
      self_evaluation: artist.selfEvaluation,
      memo: artist.memo,
    })
    if (callback) {
      callback()
    } else {
      getAllArtist()
    }
  }

  const store = async (artist: Artist, authorImg: File | null) => {
    await axios.post(urls.store, {
      author_name: artist.authorName,
      description: artist.description,
      self_evaluation: artist.selfEvaluation,
      memo: artist.memo,
    })
  }
  /**
   * 受け取ったArtistをフォームデータに変換して登録
   * 
   * @param {Artist} artist
   * @param {File | null} authorImg
   */
  const storeForm = async (artist: Artist, authorImg: File | null) => {
    const formData = new FormData()
    formData.append('author_name', artist.authorName)
    formData.append('description', artist.description)
    formData.append('self_evaluation', artist.selfEvaluation.toString())
    formData.append('memo', artist.memo)
    if (authorImg) {
      formData.append('author_image', authorImg)
    }
    await axios.post(urls.store, formData)
  }

  const deleteRecord = async (record: Artist) => {
    await axios.delete(urls.delete(record.authorId))
    getAllArtist()
  }

  const getDetail = async (id: number) => {
    await axios.get(urls.getDetail(id))
  }

  const uploadImage = async (artist: Artist, img: File | null, callback?: (url: string) => void) => {
    const formData = new FormData();
    if (img) {
      formData.append('author_img', img);
    }

    const response = await axios.post(urls.upsertImage(artist.authorId), formData);
    // ファイル名を取得
    const fileName = response.data.author_image;
    if (fileName && callback) {
      callback(fileName);
    }
  }

  const getRecordsByAuthorId = async (id: number) => {
    const response = await axios.get(urls.getRecordsByAuthorId(id))
    recordData.value = response.data.map((record: any) => ({
      id: record.record_id,
      name: record.record_name,
      imagePath: record.record_image,
      description: record.description,
      evaluation: record.self_evaluation,
      authorId: record.author_id,
      memo: record.memo,
    }))
  }

  return {
    artists,
    recordData,
    detailData,
    mounted,
    getAllArtist,
    update,
    store,
    storeForm,
    deleteRecord,
    uploadImage,
    getRecordsByAuthorId,
  }
}