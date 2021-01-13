export const state = () => ({
    beritas: {
        data: [],
        total: 0,
        current_page: 1
    },
    brtLoader: false
})
  
export const mutations = {
    setBeritas(state, data) {
      state.beritas = data
    },
    setLoader(state){
        state.brtLoader = !state.brtLoader
    },
    setPage(state, data){
        state.beritas.current_page = data
    }
}

export const getters = {
    getBeritas(state) {
         return state.beritas
    },
    getLoader(state){
        return state.brtLoader
    },
    setPage(state, data){
        state.beritas.current_page = data
    }
};

export const actions = {
    getAll(context, {showall = 1, search = '', defaultPage = false}){
        context.commit("setLoader")
        let page = defaultPage ? 1 : context.state.beritas.current_page
        this.$axios.get(`/beritas?showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setBeritas', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    }
}