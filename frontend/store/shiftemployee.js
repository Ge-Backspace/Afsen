export const state = () => ({
  shiftE: {
    data: [],
    total: 0,
    current_page: 1,
  },
  shiftELoader: false,
})

export const mutations = {
  setSE(state, data) {
    state.shiftE = data
  },
  setLoader(state){
    state.shiftELoader = !state.shiftELoader
  },
  setPage(state, data){
    state.shiftE.current_page = data
  }
}

export const getters = {
  getSE(state) {
    return state.shiftE
  },
  getLoader(state){
    return state.shiftELoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    context.commit('setLoader')
    let page = defaultPage ? 1 : context.state.shiftE.current_page
    this.$axios.get(`/companyShiftEmployee?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setSE', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
