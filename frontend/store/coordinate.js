export const state = () => ({
  coordinates: {
    data: [],
  },
  coordinateLoader: false,
})

export const mutations = {
  setCoordinate(state, data) {
    state.coordinates.data = data
  },
  setLoader(state){
    state.compLoader = !state.compLoader
  },
}

export const getters = {
  getCoordinate(state) {
    return state.coordinates
  },
  getLoader(state){
    return state.compLoader
  },
};

export const actions = {
  getLocation(context, {company_id = ''}){
    context.commit('setLoader')
    this.$axios.get(`/getCoordinate?company_id=${company_id}`).then(resp => {
        context.commit('setCoordinate', resp.data.data)
    }).catch(e => {
        console.log(e)
    }).finally(() => {
        context.commit('setLoader')
    })
  },
}
