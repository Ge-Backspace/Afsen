export const state = () => ({
    employees: {
      data: [],
      total: 0,
      current_page: 1
    },
    employeeLoader: false,
    // summary: {
    //     aktif: 0,
    //     non_aktif: 0
    // }
  })

  export const mutations = {
    setEmployees(state, data) {
      state.employees = data
    },
    setLoader(state){
        state.employeeLoader = !state.employeeLoader
    },
    // setPage(state, data){
    //     state.users.current_page = data
    // },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }

  export const getters = {
    getEmployees(state) {
         return state.employees
    },
    getLoader(state){
        return state.employeeLoader
    },
    // getSummary(state){
    //     return state.summary
    // }
  };

  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit("setLoader")
      let page = defaultPage ? 1 : context.state.employees.current_page
      this.$axios.get(`/employees?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setEmployees', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
    },
    // getUserSummary(context){
    //     this.$axios.get(`/user-summary`).then(resp => {
    //         context.commit('setSummary', resp.data.data)
    //     }).catch(e => {
    //         console.log(e)
    //     }).finally(() => {
    //         // context.commit("setLoader")
    //     })
    // }
  }
