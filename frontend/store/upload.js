export const state = () => ({
    upload: {
      data: [],
      total: 0,
      current_page: 1
    },
    uploadLoader: false,
    // summary: {
    //     aktif: 0,
    //     non_aktif: 0
    // }
  })

  export const mutations = {
    setUploads(state, data) {
      state.upload = data
    },
    setLoader(state){
        state.uploadLoader = !state.uploadLoader
    },
    // setPage(state, data){
    //     state.users.current_page = data
    // },
    // setSummary(state, data){
    //     state.summary = data
    // }
  }

  export const getters = {
    getUploads(state) {
         return state.upload
    },
    getLoader(state){
        return state.uploadLoader
    },
    // getSummary(state){
    //     return state.summary
    // }
  };

  export const actions = {
    getAll(context){
      context.commit("setLoader")
      let page = defaultPage ? 1 : context.state.uploads.current_page
      this.$axios.get(`/test`).then(resp => {
          context.commit('setUploads', resp.data)
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
