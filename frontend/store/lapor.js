export const state = () => ({
    lapors: {
        data: [],
        total: 0,
        current_page: 1
    },
    laporLoader: false,
    laporan: null,
    evidence: []
})
  
export const mutations = {
    setLapors(state, data) {
      state.lapors = data
    },
    setLoader(state){
        state.laporLoader = !state.laporLoader
    },
    setPage(state, data){
        state.lapors.current_page = data
    },
    setLaporan(state, data){
        state.laporan = data
    },
    setEvidence(state, data){
        state.evidence = data
    }
}

export const getters = {
    getLapors(state) {
         return state.lapors
    },
    getLoader(state){
        return state.laporLoader
    },
    getLaporan(state){
        return state.laporan
    },
    getEvidence(state){
        return state.evidence
    }
};

export const actions = {
    getAll(context, {showall = 1, search = '', defaultPage = false, start_date = '', end_date = '', goverment = ''}){
        context.commit("setLoader")
        let page = defaultPage ? 1 : context.state.lapors.current_page
        this.$axios.get(`/lapors?showall=${showall}&page=${page}&search=${search}&start_date=${start_date}&end_date=${end_date}&goverment=${goverment}`).then(resp => {
            context.commit('setLapors', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    },
    getEvidenceAll(context, {id = 1}){
        context.commit("setLoader")
        this.$axios.get(`/lapor/${id}/evidences`).then(resp => {
            context.commit('setEvidence', resp.data)
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            context.commit("setLoader")
        })
    },
}