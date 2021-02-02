export const state = () => ({
    positions: {
      data: [],
    },
    employees: {
      data:[],
    },
    shifts: {
      data:[],
    },
    cutis: {
      data: [],
    }
})

export const mutations = {
    setOptionPositions(state, data) {
      state.positions = data
    },
    setOptionEmployees(state, data) {
      state.employees = data
    },
    setOptionShifts(state, data) {
      state.shifts = data
    },
    setOptionCuties(state, data) {
      state.cutis = data
    }
}

export const getters = {
    getOptionPositions(state) {
         return state.positions
    },
    getOptionEmployees(state) {
      return state.employees
    },
    getOptionShifts(state) {
      return state.shifts
    },
    getOptionCuties(state) {
      return state.cutis
    }
};

export const actions = {
    getOptionPositions(context, {company_id = ''}){
      this.$axios.get(`/optionPosition?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionPositions', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },

    getOptionEmployees(context, {company_id = ''}){
      this.$axios.get(`/optionEmployee?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionEmployees', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },

    getOptionShifts(context, {company_id = ''}){
      this.$axios.get(`/optionShift?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionShifts', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },
    getOptionCuties(context, {company_id = ''}){
      this.$axios.get( `/optionCuti?company_id=${company_id}`).
      then(resp => {
        context.commit(`setOptionCuties`, resp.data)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        //context.commit("setLoader")
      })
    }
}
