export const state = () => ({
	attendance: {
		data: [],
		total: 0,
		current_page: 1
	},
    attendanceLoader: false,
    
	salary: {
		data: [],
		total: 0,
		current_page: 1
	},
    salaryLoader: false,
    
	permission: {
		data: [],
		total: 0,
		current_page: 1
	},
    permissionLoader: false,
    
	employee: {
		data: [],
		total: 0,
		current_page: 1
	},
	employeeLoader: false
});

export const mutations = {
	//Attendance Mutation
	setAttendance(state, data) {
		state.attendance = data;
    },
    setSalary(state, data) {
		state.salary = data;
    },
    setPermission(state, data) {
		state.permission = data;
    },
    setEmployee(state, data) {
		state.employee = data;
    },
    

	setLoader(state) {
        state.attendanceLoader = !state.attendanceLoader;
        state.salaryLoader = !state.salaryLoader;
        state.permissionLoader = !state.permissionLoader;
        state.employeeLoader = !state.employeeLoader;
	},
	setPage(state, data) {
        state.attendance.current_page = data;
        state.salary.current_page = data;
        state.permission.current_page = data;
        state.employee.current_page = data;
	},

	
};

export const getters = {
	//Attendance Getters
	getAttendance(state) {
		return state.attendance;
    },
    getSalary(state) {
		return state.salary;
    },
    getPermission(state) {
		return state.permission;
    },
    getEmployee(state) {
		return state.employee;
    },
    
	getLoaderAttendance(state) {
        return state.salaryLoader;
        
        
    },
    getLoaderSalary(state) {
        return state.attendanceLoader;
    },
    getLoaderPermission(state) {
        return state.permissionLoader;
    },
    getLoaderEmployee(state) {
        return state.employeeLoader;
    },

};

export const actions = {
    getAttendance(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      this.$axios.get(`/reportAttendance?company_id=${company_id}&startDate=${startDate}&endDate=${endDate}`)
      .then(resp => {
          context.commit('setAttendance', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },

    getSalary(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      this.$axios.get(`/reportSalary?company_id=${company_id}`)
      .then(resp => {
          context.commit('setSalary', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },

    getPermission(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      this.$axios.get(`/reportPermission?company_id=${company_id}`)
      .then(resp => {
          context.commit('setPermission', resp.data)
      }).catch(e => {
          console.log(e)
      }).finally(() => {
          // context.commit("setLoader")
      })
    },

    getEmployee(context, {company_id = '', showall = 1, search = '', defaultPage = false}){
      this.$axios.get( `/reportEmployee?company_id=${company_id}`).
      then(resp => {
        context.commit(`setEmployee`, resp.data)
      }).catch(e => {
        console.log(e)
      }).finally(() => {
        //context.commit("setLoader")
      })
    },
}