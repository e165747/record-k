import { createStore } from 'vuex'
import loading from './modules/loading'

// ストアのインジェクションキー
export const key = Symbol()

const store = createStore({
  modules: {
    loading,
  }
})

export default store