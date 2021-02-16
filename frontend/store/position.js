export const state = () => ({
    position: {
      data: [],
      total: 0,
      current_page: 1
    },
    positionLoader: false,
    // summary: {
    //     aktif: 0,
    //     non_aktif: 0
    // }
  })

  export const mutations = {
    setPositions(state, data) {
      state.position = data
    },
    setLoader(state){
        state.positionLoader = state.positionLoader
    },
    setPage(state, data){
        state.positions.current_page = data
    },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }

  export const getters = {
    getPositions(state) {
         return state.position
    },
    getLoader(state){
        return state.positionLoader
    },
    // getSummary(state){
    //     return state.summary
    // }
  };

  export const actions = {
    getAll(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
        context.commit('setLoader')
        let page = defaultPage ? 1 : context.state.position.current_page
        this.$axios.get(`/positions?company_id=${company_id}&$showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setPositions', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit('setLoader')
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
