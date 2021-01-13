export const state = () => ({
    kegiatans: {
        data: [],
        total: 0,
        current_page: 1
    },
    kegLoader: false
})
  
export const mutations = {
    setKegiatans(state, data) {
      state.kegiatans = data
    },
    setLoader(state){
        state.kegLoader = !state.kegLoader
    },
    setPage(state, data){
        state.kegiatans.current_page = data
    }
}

export const getters = {
    getKegiatans(state) {
         return state.kegiatans
    },
    getLoader(state){
        return state.kegLoader
    },
    setPage(state, data){
        state.kegiatans.current_page = data
    }
};

export const actions = {
    getAll(context, {showall = 1, search = '', defaultPage = false}){
        context.commit("setLoader")
        let page = defaultPage ? 1 : context.state.kegiatans.current_page
        this.$axios.get(`/kegiatans?showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setKegiatans', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    }
}