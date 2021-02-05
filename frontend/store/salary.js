export const state = () => ({
    salary: {
      data: [],
      total: 0,
      current_page: 1
    },
    salaryLoader: false,
  })

  export const mutations = {
    setSalary(state, data) {
      state.salary = data
    },
    setLoader(state){
        state.salaryLoader = !state.salaryLoader
    },
    setPage(state, data){
        state.salary.current_page = data
    },
  }

  export const getters = {
    getSalary(state) {
         return state.salary
    },
    getLoader(state){
        return state.salaryLoader
    },
  };

  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit('setLoader')
      let page = defaultPage ? 1 : context.state.salary.current_page
      this.$axios.get(`/gajis?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setSalary', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit('setLoader')
      })
    },
  }
