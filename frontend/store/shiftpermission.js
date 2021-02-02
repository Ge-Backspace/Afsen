export const state = () => ({
  shiftP: {
    data: [],
    total: 0,
    current_page: 1
  },
  shiftPLoader: false,
})

export const mutations = {
  setShiftPs(state, data) {
    state.shiftP = data
  },
  setLoader(state){
      state.shiftPLoader = !state.shiftPLoader
  },
  setPage(state, data){
      state.shiftP.current_page = data
  },
}

export const getters = {
  getShiftPs(state) {
       return state.shiftP
  },
  getLoader(state){
      return state.shiftPLoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    context.commit('setLoader')
    let page = defaultPage ? 1 : context.state.shiftP.current_page
    this.$axios.get(`/shiftpermissions?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setShiftPs', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
