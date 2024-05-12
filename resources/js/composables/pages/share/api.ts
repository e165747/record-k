// axiosを用いたAPI呼び出しの共通処理を実装する

import axios from "axios"

// 全処理共通で，Unauthorizedエラーが発生した場合はログインページにリダイレクトする
export const useApi = () => {
  const api = axios.create({
    baseURL: '/api',
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    },
  })

  api.interceptors.response.use(
    response => response,
    error => {
      if (error.response.status === 401) {
        window.location.href = '/login'
      }

      return Promise.reject(error)
    }
  )

  return api
}

