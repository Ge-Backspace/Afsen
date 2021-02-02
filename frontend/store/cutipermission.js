export const state = () => ({
  cutiP: {
    data: [],
    total: 0,
    current_page: 1
  },
  cutiPLoader: false,
})

export const mutations = {
  setCutiPs(state, data) {
    state.cutiP = data
  },
  setLoader(state){
      state.cutiPLoader = !state.cutiPLoader
  },
  setPage(state, data){
      state.cutiP.current_page = data
  },
}

export const getters = {
  getCutiPs(state) {
       return state.cutiP
  },
  getLoader(state){
      return state.cutiPLoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
    context.commit('setLoader')
    let page = defaultPage ? 1 : context.state.cutiP.current_page
    this.$axios.get(`/cutipermissions?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setCutiPs', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
