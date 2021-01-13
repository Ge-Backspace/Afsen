export const state = () => ({
    chart: {
        segmentasi: [],
        time: {
            week: [],
            month: [],
            year:[]
        },
        kategori: []
    }
})
  
export const mutations = {
    setChart(state, data) {
      state.chart[data.type] = data.data
    },
}

export const getters = {
    getChart(state) {
         return state.chart
    },
};

export const actions = {
    getChartLaporanMasuk(context, {type, goverment = ''}){
        this.$axios.get(`/laporan-masuk/${type}?goverment=${goverment}`).then(resp => {
            context.commit('setChart', {
                type: type,
                data: resp.data.data
            })
        }).catch(e => {
            console.log(e)
        }).finally(() => {
            //
        })
    }
}