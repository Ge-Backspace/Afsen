export const state = () => ({
    setting: {
        position: [],
        employee: [],
        shift: [],
    },
})
  
export const mutations = {
    setSetting(state, data) {
      state.setting[data.type] = data.value
    },
}

export const getters = {
    getSetting(state) {
         return state.setting
    }
};

export const actions = {
    getAll(context, {company_id = ''}){
        let setting = context.state.setting
        Object.keys(setting).forEach((key) => {
            this.$axios.get(`//${key}`).then(resp => {
                context.commit('setSetting', {
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