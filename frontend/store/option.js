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
    },
    shift_employees1: {
      data: [],
    },
    shift_employees2: {
      data: [],
    },

    optionLoader: false,
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
    },
    setOptionShiftEmployees1(state, data) {
      state.shift_employees1 = data
    },
    setOptionShiftEmployees2(state, data) {
      state.shift_employees2 = data
    },
    setLoader(state){
      state.optionLoader = state.optionLoader
  },
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
    },
    getOptionShiftE1(state) {
      return state.shift_employees1
    },
    getOptionShiftE2(state) {
      return state.shift_employees2
    },
    getLoader(state){
      return state.optionLoader
  },
};

export const actions = {
    getOptionPositions(context, {company_id = ''}){
      context.commit('setLoader')
      this.$axios.get(`/optionPosition?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionPositions', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
    },

    getOptionEmployees(context, {company_id = ''}){
      context.commit('setLoader')
      this.$axios.get(`/optionEmployee?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionEmployees', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
    },

    getOptionShifts(context, {company_id = ''}){
      context.commit('setLoader')
      this.$axios.get(`/optionShift?company_id=${company_id}`)
      .then(resp => {
          context.commit('setOptionShifts', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          context.commit("setLoader")
      })
    },

    getOptionCuties(context, {company_id = ''}){
      context.commit('setLoader')
      this.$axios.get( `/optionCuti?company_id=${company_id}`).
      then(resp => {
        context.commit(`setOptionCuties`, resp.data)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        context.commit("setLoader")
      })
    },

    getOptionShiftEmployee1(context, {employee_id = ''}){
      context.commit('setLoader')
      this.$axios.get( `/optionShiftEmployee?employee_id=${employee_id}`).
      then(resp => {
        context.commit(`setOptionShiftEmployees1`, resp.data)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        context.commit("setLoader")
      })
    },

    getOptionShiftEmployee2(context, {employee_id = ''}){
      context.commit('setLoader')
      this.$axios.get( `/optionShiftEmployee?employee_id=${employee_id}`).
      then(resp => {
        context.commit(`setOptionShiftEmployees2`, resp.data)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        context.commit("setLoader")
      })
    }
}
