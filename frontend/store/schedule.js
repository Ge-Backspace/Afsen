export const state = () => ({
  schedule: {
    data: [],
    total: 0,
    current_page: 1
  },
  scheduleLoader: false,
  schedulePlains: []
})

export const mutations = {
  setSchedule(state, data) {
    state.schedule = data
  },
  setLoader(state){
    state.scheduleLoader = !state.scheduleLoader
  },
  setPage(state, data){
      state.schedule.current_page = data
  },
  setSchedulePlains(state, data){
      state.schedulePlains = data
  }
}

export const getters = {
  getSchedule(state) {
       return state.schedule
  },
  getLoader(state){
    return state.scheduleLoader
  },
  getSchedulePlains(state){
      return state.schedulePlains
  }
};

export const actions = {
  getAll(context, {showall = 1, search = '', defaultPage = false, company_id = ''}){
      context.commit("setLoader")
      let page = defaultPage ? 1 : context.state.schedule.current_page
      this.$axios.get(`/schedules?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setSchedule', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
  },
}
