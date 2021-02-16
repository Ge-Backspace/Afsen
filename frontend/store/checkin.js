export const state = () => ({
  checkin: {
    checkin: [],
    total: 0,
    current_page: 1
  },
  checkinLoader: false,
})

export const mutations = {
  setCheckin(state, data) {
    state.checkin.data = data
  },
  setLoader(state){
      state.checkinLoader = !state.checkinLoader
  },
  setPage(state, data){
      state.checkin.current_page = data
  },
  // setSummary(state, data){
  //     state.summary = data
  // }
}

export const getters = {
  getCheckin(state) {
       return state.checkin
  },
  getLoader(state){
      return state.checkinLoader
  },
  // getSummary(state){
  //     return state.summary
  // }
};

export const actions = {
  getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false},){
      context.commit("setLoader")
      let page = defaultPage ? 1 : context.state.checkin.current_page
      this.$axios.get(`/todayAttendance?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`)
      .then(resp => {
        context.commit('setCheckin', resp.data.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
  },
  // getCheckinrSummary(context){
  //     this.$axios.get(`/checkin-summary`).then(resp => {
  //         context.commit('setSummary', resp.data.data)
  //     }).catch(e => {
  //         console.log(e)
  //     }).finally(() => {
  //         // context.commit("setLoader")
  //     })
  // }
}
