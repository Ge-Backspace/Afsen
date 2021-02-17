export const state = () => ({
  overtime: {
    data: [],
    total: 0,
    current_page: 1
  },
  compLoader: false,
})

export const mutations = {
  setOverTime(state, data) {
    state.overtime = data
  },
  setLoader(state){
      state.compLoader = !state.compLoader
  },
  setPage(state, data){
      state.overtime.current_page = data
  },
}

export const getters = {
  getOverTime(state) {
       return state.overtime
  },
  getLoader(state){
      return state.compLoader
  },
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit('setLoader')
      let page = defaultPage ? 1 : context.state.overtime.current_page
      this.$axios.get(`/lemburpermissions?company_id=${company_id}&$showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setOverTime', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit('setLoader')
      })
  },
}
