export const state = () => ({
    goverments: {
        data: [],
        total: 0,
        current_page: 1
    },
    govLoader: false,
    govermentPlains: []
})
  
export const mutations = {
    setGoverments(state, data) {
      state.goverments = data
    },
    setLoader(state){
        state.govLoader = !state.govLoader
    },
    setPage(state, data){
        state.goverments.current_page = data
    },
    setGovermentPlains(state, data){
        state.govermentPlains = data
    }
}

export const getters = {
    getGoverments(state) {
         return state.goverments
    },
    getLoader(state){
        return state.govLoader
    },
    getGovermentPlains(state){
        return state.govermentPlains
    }
};

export const actions = {
    getAll(context, {showall = 1, search = '', defaultPage = false}){
        context.commit("setLoader")
        let page = defaultPage ? 1 : context.state.goverments.current_page
        this.$axios.get(`/goverments?showall=${showall}&page=${page}&search=${search}`).then(resp => {
            context.commit('setGoverments', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    },
    getPlains(context, {showall = 0, search = ''}){
        this.$axios.get(`/goverments?showall=${showall}&plain=1&search=${search}`).then(resp => {
            context.commit('setGovermentPlains', resp.data.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            //
        })
    }
}