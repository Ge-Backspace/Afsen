export const state = () => ({
  company: {
    id: '',
    name: '',
    data: [],
    total: 0,
    current_page: 1
  },
  compLoader: false,
  companyPlains: []
})

export const mutations = {
  setCompany(state, data) {
    state.company = data
  },
  setLoader(state){
    state.compLoader = !state.compLoader
  },
  setPage(state, data){
      state.company.current_page = data
  },
  setCompanyPlains(state, data){
      state.companyPlains = data
  }
}

export const getters = {
  getCompany(state) {
       return state.company
  },
  getLoader(state){
    return state.compLoader
  },
  getCompanyPlains(state){
      return state.companyPlains
  }
};

export const actions = {
  getAll(context, {showall = 1, search = '', defaultPage = false}){
      context.commit("setLoader")
      let page = defaultPage ? 1 : context.state.company.current_page
      this.$axios.get(`/companies?showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setCompany', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
  },
  getCompany(context, {company_id = '',showall = 1, search = '', defaultPage = false}){
    context.commit("setLoader")
    let page = defaultPage ? 1 : context.state.company.current_page
    this.$axios.get(`/companies?company_id=${company_id}showall=${showall}&page=${page}&search=${search}`).then(resp => {
        context.commit('setCompany', resp.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit("setLoader")
    })
  },
}
