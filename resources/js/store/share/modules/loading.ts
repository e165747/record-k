// Stateの型定義
interface LoadingState {
  isLoading: boolean
}

const state: LoadingState = {
  isLoading: false
}

const mutations = {
  setLoading(state: LoadingState, loading: boolean) {
    state.isLoading = loading
  }
}

const actions = {
  startLoading({ commit }: { commit: Function }) {
    commit('setLoading', true)
  },
  endLoading({ commit }: { commit: Function }) {
    commit('setLoading', false)
  }
}

const getters = {
  getLoadingState: (state: LoadingState) => state.isLoading
}

const loading = {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

export default loading