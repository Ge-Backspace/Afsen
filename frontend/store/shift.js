export const state = () => ({
    shift: {
      email: '',
      data: [],
      total: 0,
      current_page: 1
    },
    // shiftLoader: false,
    // summary: {
    //     aktif: 0,
    //     non_aktif: 0
    // }
  })
  
  export const mutations = {
    setShifts(state, data) {
      state.shift.data = data
    },
    setLoader(state){
        state.shiftLoader = state.shiftLoader
    },
    // setPage(state, data){
    //     state.shift.current_page = data
    // },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }
  
  export const getters = {
    getShifts(state) {
         return state.shift
    },
    getLoader(state){
        return state.shiftLoader
    },
    // getSummary(state){
    //     return state.summary
    // }
  };
  
  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
        let page = defaultPage ? 1 : context.state.shift.current_page
        this.$axios.get(`/shifts?company_id=${company_id}&showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setShifts', resp.data.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            // context.commit("setLoader")
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
  