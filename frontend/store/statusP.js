export const state = () => ({
  statusP: {
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
  setStatusPs(state, data) {
    state.statusP = data
  },
  setLoader(state){
      state.statusPLoader = state.statusPLoader
  },
  setPage(state, data){
      state.statusP.current_page = data
  },
  // setSummary(state, data){
  //     state.summary = data
  // }
}

export const getters = {
  getStatusPs(state) {
       return state.statusP
  },
  getLoader(state){
      return state.statusPLoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    let page = defaultPage ? 1 : context.state.statusP.current_page
    this.$axios.get(`/statusPermissions?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setStatusPs', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
