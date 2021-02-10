export const state = () => ({
    office: {
      email: '',
      data: [],
      total: 0,
      current_page: 1
    },
    officeLoader: false,
    // summary: {
    //     aktif: 0,
    //     non_aktif: 0
    // }
  })

  export const mutations = {
    setOffices(state, data) {
      state.office = data
    },
    setLoader(state){
        state.officeLoader = !state.officeLoader
    },
    setPage(state, data){
        state.office.current_page = data
    },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }

  export const getters = {
    getOffices(state) {
         return state.office
    },
    getLoader(state){
        return state.officeLoader
    },
  };

  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit('setLoader')
      let page = defaultPage ? 1 : context.state.office.current_page
      this.$axios.get(`/offices?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setOffices', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit('setLoader')
      })
    },
  }
