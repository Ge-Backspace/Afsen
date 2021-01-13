export const state = () => ({
    informations: {
        data: [],
        total: 0,
        current_page: 1
    },
    infLoader: false
})
  
export const mutations = {
    setInformations(state, data) {
      state.informations = data
    },
    setLoader(state){
        state.infLoader = !state.infLoader
    },
    setPage(state, data){
        state.informations.current_page = data
    }
}

export const getters = {
    getInformations(state) {
         return state.informations
    },
    getLoader(state){
        return state.infLoader
    },
    setPage(state, data){
        state.informations.current_page = data
    }
};

export const actions = {
    getAll(context, {showall = 1, search = '', defaultPage = false}){
        context.commit("setLoader")
        let page = defaultPage ? 1 : context.state.informations.current_page
        this.$axios.get(`/informations?showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setInformations', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    }
}