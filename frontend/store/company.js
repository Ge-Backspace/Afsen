export const state = () => ({
  company: {
      id: '',
      name: '',
  }
})

export const mutations = {
  setCompany(state, data) {
    state.company = data
  },
}

export const getters = {
  getCompany(state) {
       return state.company
  },
};
