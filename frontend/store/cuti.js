export const state = () => ({
  cuti: {
    email: '',
    data: [],
    total: 0,
    current_page: 1
  },
  cutiLoader: false,
  // summary: {
  //     aktif: 0,
  //     non_aktif: 0
  // }
})

export const mutations = {
  setCutis(state, data) {
    state.cuti = data
  },
  setLoader(state){
      state.cutiLoader = state.cutiLoader
  },
  setPage(state, data){
      state.cuti.current_page = data
  },
  // setSummary(state, data){
  //     state.summary = data
  // }
}

export const getters = {
  getCutis(state) {
       return state.cuti
  },
  getLoader(state){
      return state.cutiLoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    let page = defaultPage ? 1 : context.state.cuti.current_page
    this.$axios.get(`/cutis?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setCutis', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
