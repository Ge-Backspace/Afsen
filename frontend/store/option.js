export const state = () => ({
    option: {
        position_name: [],
        group: []
    },
})
  
export const mutations = {
    setOption(state, data) {
      state.option[data.type] = data.value
    },
}

export const getters = {
    getOption(state) {
         return state.option
    }
};

export const actions = {
    getAll(context){
        let option = context.state.option
        Object.keys(option).forEach((key) => {
            this.$axios.get(`/positions/company_id=${company_id}`).then(resp => {
                context.commit('setOption', {
                    type: key,
                    value: resp.data.data
                })
            }).catch(e => {
                console.log(e)
            }).finally(() => {
                //
            })
        });
    }
}