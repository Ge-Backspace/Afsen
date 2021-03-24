export const state = () => ({
    attendance: {
      data: [],
      total: 0,
      current_page: 1
    },
    attendanceLoader: false,
  })

  export const mutations = {
    setAttendances(state, data) {
      state.attendance = data
    },
    setLoader(state){
        state.attendanceLoader = !state.attendanceLoader
    },
    setPage(state, data){
        state.attendance.current_page = data
    },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }

  export const getters = {
    getAttendances(state) {
         return state.attendance
    },
    getLoader(state){
        return state.attendanceLoader
    },
  };

  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit('setLoader')
      let page = defaultPage ? 1 : context.state.attendance.current_page
      this.$axios.get(`/attendances?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setAttendances', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit('setLoader')
      })
    },

    getUser(context, {user_id = '', showall = 1, search = '', defaultPage = false}){
      context.commit('setLoader')
      let page = defaultPage ? 1 : context.state.attendance.current_page
      this.$axios.get(`/attendances?user_id=${user_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
          context.commit('setAttendances', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit('setLoader')
      })
    },
  }
