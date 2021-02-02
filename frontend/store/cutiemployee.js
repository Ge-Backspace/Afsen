export const state = () => ({
  cutiE: {
    data: [],
    total: 0,
    current_page: 1
  },
  cutiELoader: false,
  // summary: {
  //     aktif: 0,
  //     non_aktif: 0
  // }
})

export const mutations = {
  setCutiEs(state, data) {
    state.cutiE = data
  },
  setLoader(state){
      state.cutiELoader = !state.cutiELoader
  },
  setPage(state, data){
      state.cutiE.current_page = data
  },
  // setSummary(state, data){
  //     state.summary = data
  // }
}

export const getters = {
  getCutiEs(state) {
       return state.cutiE
  },
  getLoader(state){
      return state.cutiELoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    context.commit('setLoader')
    let page = defaultPage ? 1 : context.state.cutiE.current_page
    this.$axios.get(`/cutiemployees?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setCutiEs', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
