export const state = () => ({
    option: {
        position: [],
        employee: [],
        shift: []
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
    getPosition(context, {company_id = ''}){
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
    },

    getEmployee(context, {company_id = ''}){
        let option = context.state.option
        Object.keys(option).forEach((key) => {
            this.$axios.get(`/employees/company_id=${company_id}`).then(resp => {
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
    },

    getShift(context, {company_id = ''}){
        let option = context.state.option
        Object.keys(option).forEach((key) => {
            this.$axios.get(`/shifts/company_id=${company_id}`).then(resp => {
                context.commit('setOption', {
                    type: key,
                    value: resp.data.data
                })
            }).catch(e => {
                console.log(e)
            }).finally(() => {

            })
        });
    },
}