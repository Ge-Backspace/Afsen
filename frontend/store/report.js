export const state = () => ({
  attendance: {
    data: [],
  },
  compLoader: false,
})

export const mutations = {
  setReportAttendance(state, data) {
    state.attendance.data = data
  },
  setLoader(state){
      state.compLoader = !state.compLoader
  },
}

export const getters = {
  getReportAttendance(state) {
    return state.attendance
  },
  getLoader(state){
    return state.compLoader
  },
};

export const actions = {
  getAttendance(context, {company_id = '', startDate = '', endDate = ''}){
    context.commit('setLoader')
    this.$axios.get(`/reportAttendance?company_id=${company_id}&startDate=${startDate}&endDate=${endDate}`).then(resp => {
        context.commit('setReportAttendance', resp.data.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
