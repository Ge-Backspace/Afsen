export const state = () => ({
    chart: {
        data:[]
    }
})

export const mutations = {
    setChart(state, data) {
      state.chart = data
    },
}

export const getters = {
    getChart(state) {
         return state.chart
    },
};

export const actions = {
    getApiChart(context, {type = ''}){
        this.$axios.get(`/statCompany`).then(resp => {
            context.commit('setChart', {
                data: resp.data.data
            })
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            //
        })
    }
}
