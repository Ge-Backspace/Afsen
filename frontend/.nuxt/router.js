import Vue from 'vue'
import Router from 'vue-router'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

<<<<<<< HEAD
const _d1506482 = () => interopDefault(import('..\\pages\\company_check.vue' /* webpackChunkName: "pages/company_check" */))
const _192e645f = () => interopDefault(import('..\\pages\\LandingPage.vue' /* webpackChunkName: "pages/LandingPage" */))
const _2fa131e2 = () => interopDefault(import('..\\pages\\login.vue' /* webpackChunkName: "pages/login" */))
const _716dd03c = () => interopDefault(import('..\\pages\\profile.vue' /* webpackChunkName: "pages/profile" */))
const _75bd03ba = () => interopDefault(import('..\\pages\\register.vue' /* webpackChunkName: "pages/register" */))
const _535068b0 = () => interopDefault(import('..\\pages\\register_account.vue' /* webpackChunkName: "pages/register_account" */))
const _f72c5410 = () => interopDefault(import('..\\pages\\register_company.vue' /* webpackChunkName: "pages/register_company" */))
const _9b920fa0 = () => interopDefault(import('..\\pages\\reset-password.vue' /* webpackChunkName: "pages/reset-password" */))
const _a02f3cae = () => interopDefault(import('..\\pages\\test.vue' /* webpackChunkName: "pages/test" */))
const _7db0123e = () => interopDefault(import('..\\pages\\admin\\beranda.vue' /* webpackChunkName: "pages/admin/beranda" */))
const _5fa05f22 = () => interopDefault(import('..\\pages\\admin\\berita.vue' /* webpackChunkName: "pages/admin/berita" */))
const _03e9f406 = () => interopDefault(import('..\\pages\\admin\\company\\index.vue' /* webpackChunkName: "pages/admin/company/index" */))
const _1a97bb9c = () => interopDefault(import('..\\pages\\admin\\company1.vue' /* webpackChunkName: "pages/admin/company1" */))
const _db511c16 = () => interopDefault(import('..\\pages\\admin\\employees\\index.vue' /* webpackChunkName: "pages/admin/employees/index" */))
const _9fedcf54 = () => interopDefault(import('..\\pages\\admin\\informasi.vue' /* webpackChunkName: "pages/admin/informasi" */))
const _512a2cb8 = () => interopDefault(import('..\\pages\\admin\\kegiatan.vue' /* webpackChunkName: "pages/admin/kegiatan" */))
const _0d4491c8 = () => interopDefault(import('..\\pages\\admin\\lapor\\index.vue' /* webpackChunkName: "pages/admin/lapor/index" */))
const _7b984c97 = () => interopDefault(import('..\\pages\\admin\\permission.vue' /* webpackChunkName: "pages/admin/permission" */))
const _ffe80d08 = () => interopDefault(import('..\\pages\\admin\\report.vue' /* webpackChunkName: "pages/admin/report" */))
const _c12399dc = () => interopDefault(import('..\\pages\\admin\\salary.vue' /* webpackChunkName: "pages/admin/salary" */))
const _1cd32c6a = () => interopDefault(import('..\\pages\\admin\\shift.vue' /* webpackChunkName: "pages/admin/shift" */))
const _4960116c = () => interopDefault(import('..\\pages\\admin\\shiftEmployee\\index.vue' /* webpackChunkName: "pages/admin/shiftEmployee/index" */))
const _36aa35da = () => interopDefault(import('..\\pages\\admin\\test.vue' /* webpackChunkName: "pages/admin/test" */))
const _0647ca20 = () => interopDefault(import('..\\pages\\admin\\users.vue' /* webpackChunkName: "pages/admin/users" */))
const _04bf1d96 = () => interopDefault(import('..\\pages\\admin\\company\\announcement\\index.vue' /* webpackChunkName: "pages/admin/company/announcement/index" */))
const _13436707 = () => interopDefault(import('..\\pages\\admin\\company\\asset\\index.vue' /* webpackChunkName: "pages/admin/company/asset/index" */))
const _3dfaa299 = () => interopDefault(import('..\\pages\\admin\\company\\document_template\\index.vue' /* webpackChunkName: "pages/admin/company/document_template/index" */))
const _786f25c0 = () => interopDefault(import('..\\pages\\admin\\company\\files\\index.vue' /* webpackChunkName: "pages/admin/company/files/index" */))
const _453ca102 = () => interopDefault(import('..\\pages\\admin\\company\\onboarding\\index.vue' /* webpackChunkName: "pages/admin/company/onboarding/index" */))
const _4c921d14 = () => interopDefault(import('..\\pages\\admin\\company\\polling\\index.vue' /* webpackChunkName: "pages/admin/company/polling/index" */))
const _d331da4e = () => interopDefault(import('..\\pages\\admin\\company\\reprimand\\index.vue' /* webpackChunkName: "pages/admin/company/reprimand/index" */))
const _182f4598 = () => interopDefault(import('..\\pages\\admin\\company\\task\\index.vue' /* webpackChunkName: "pages/admin/company/task/index" */))
const _4792e16f = () => interopDefault(import('..\\pages\\admin\\company\\user_activity_log\\index.vue' /* webpackChunkName: "pages/admin/company/user_activity_log/index" */))
const _50e9dc3e = () => interopDefault(import('..\\pages\\admin\\employees\\detail.vue' /* webpackChunkName: "pages/admin/employees/detail" */))
const _7ef25414 = () => interopDefault(import('..\\pages\\admin\\finances\\cash.vue' /* webpackChunkName: "pages/admin/finances/cash" */))
const _27dd115e = () => interopDefault(import('..\\pages\\admin\\finances\\loan.vue' /* webpackChunkName: "pages/admin/finances/loan" */))
const _2b6683b2 = () => interopDefault(import('..\\pages\\admin\\finances\\reimbursement.vue' /* webpackChunkName: "pages/admin/finances/reimbursement" */))
const _6aa78812 = () => interopDefault(import('..\\pages\\admin\\lapor\\detail.vue' /* webpackChunkName: "pages/admin/lapor/detail" */))
const _6c40cd42 = () => interopDefault(import('..\\pages\\admin\\master\\masterCompanies.vue' /* webpackChunkName: "pages/admin/master/masterCompanies" */))
const _0a542a5a = () => interopDefault(import('..\\pages\\admin\\master\\masterEmployee.vue' /* webpackChunkName: "pages/admin/master/masterEmployee" */))
const _73602755 = () => interopDefault(import('..\\pages\\admin\\master\\masterPosition.vue' /* webpackChunkName: "pages/admin/master/masterPosition" */))
const _fa74e2f4 = () => interopDefault(import('..\\pages\\admin\\master\\masterShift.vue' /* webpackChunkName: "pages/admin/master/masterShift" */))
const _1ae4fa12 = () => interopDefault(import('..\\pages\\admin\\master\\masterUser.vue' /* webpackChunkName: "pages/admin/master/masterUser" */))
const _17fb85c6 = () => interopDefault(import('..\\pages\\admin\\time_management\\attendance.vue' /* webpackChunkName: "pages/admin/time_management/attendance" */))
const _77fad8db = () => interopDefault(import('..\\pages\\admin\\time_management\\calendar.vue' /* webpackChunkName: "pages/admin/time_management/calendar" */))
const _5b75c898 = () => interopDefault(import('..\\pages\\admin\\time_management\\schedule.vue' /* webpackChunkName: "pages/admin/time_management/schedule" */))
const _1e3b4a43 = () => interopDefault(import('..\\pages\\admin\\time_management\\setting.vue' /* webpackChunkName: "pages/admin/time_management/setting" */))
const _e034c316 = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff.vue' /* webpackChunkName: "pages/admin/time_management/timeoff" */))
const _5a6e33ca = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff_deduction.vue' /* webpackChunkName: "pages/admin/time_management/timeoff_deduction" */))
const _65f98ecb = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))
=======
const _947adda6 = () => interopDefault(import('..\\pages\\company_check.vue' /* webpackChunkName: "pages/company_check" */))
const _14af2b4d = () => interopDefault(import('..\\pages\\LandingPage.vue' /* webpackChunkName: "pages/LandingPage" */))
const _1d757960 = () => interopDefault(import('..\\pages\\login.vue' /* webpackChunkName: "pages/login" */))
const _9fa2f460 = () => interopDefault(import('..\\pages\\profile.vue' /* webpackChunkName: "pages/profile" */))
const _acf558e8 = () => interopDefault(import('..\\pages\\register.vue' /* webpackChunkName: "pages/register" */))
const _fef7ad0c = () => interopDefault(import('..\\pages\\register_account.vue' /* webpackChunkName: "pages/register_account" */))
const _2e9633ca = () => interopDefault(import('..\\pages\\register_company.vue' /* webpackChunkName: "pages/register_company" */))
const _6124a282 = () => interopDefault(import('..\\pages\\reset-password.vue' /* webpackChunkName: "pages/reset-password" */))
const _a4352b0a = () => interopDefault(import('..\\pages\\test.vue' /* webpackChunkName: "pages/test" */))
const _7015a133 = () => interopDefault(import('..\\pages\\admin\\beranda.vue' /* webpackChunkName: "pages/admin/beranda" */))
const _22cad846 = () => interopDefault(import('..\\pages\\admin\\berita.vue' /* webpackChunkName: "pages/admin/berita" */))
const _2f2b092a = () => interopDefault(import('..\\pages\\admin\\company\\index.vue' /* webpackChunkName: "pages/admin/company/index" */))
const _495f5b8a = () => interopDefault(import('..\\pages\\admin\\company1.vue' /* webpackChunkName: "pages/admin/company1" */))
const _62af43e3 = () => interopDefault(import('..\\pages\\admin\\employees\\index.vue' /* webpackChunkName: "pages/admin/employees/index" */))
const _5a357628 = () => interopDefault(import('..\\pages\\admin\\informasi.vue' /* webpackChunkName: "pages/admin/informasi" */))
const _06328992 = () => interopDefault(import('..\\pages\\admin\\kegiatan.vue' /* webpackChunkName: "pages/admin/kegiatan" */))
const _3a57b00a = () => interopDefault(import('..\\pages\\admin\\lapor\\index.vue' /* webpackChunkName: "pages/admin/lapor/index" */))
const _16f7a905 = () => interopDefault(import('..\\pages\\admin\\permission.vue' /* webpackChunkName: "pages/admin/permission" */))
const _c312862c = () => interopDefault(import('..\\pages\\admin\\report.vue' /* webpackChunkName: "pages/admin/report" */))
const _844e1300 = () => interopDefault(import('..\\pages\\admin\\salary.vue' /* webpackChunkName: "pages/admin/salary" */))
const _dd297988 = () => interopDefault(import('..\\pages\\admin\\shift.vue' /* webpackChunkName: "pages/admin/shift" */))
const _36712238 = () => interopDefault(import('..\\pages\\admin\\shiftEmployee\\index.vue' /* webpackChunkName: "pages/admin/shiftEmployee/index" */))
const _322afcc8 = () => interopDefault(import('..\\pages\\admin\\test.vue' /* webpackChunkName: "pages/admin/test" */))
const _717431c2 = () => interopDefault(import('..\\pages\\admin\\users.vue' /* webpackChunkName: "pages/admin/users" */))
const _7e950af8 = () => interopDefault(import('..\\pages\\admin\\company\\announcement\\index.vue' /* webpackChunkName: "pages/admin/company/announcement/index" */))
const _1c4799d9 = () => interopDefault(import('..\\pages\\admin\\company\\asset\\index.vue' /* webpackChunkName: "pages/admin/company/asset/index" */))
const _1fbf2a6b = () => interopDefault(import('..\\pages\\admin\\company\\document_template\\index.vue' /* webpackChunkName: "pages/admin/company/document_template/index" */))
const _6666c01c = () => interopDefault(import('..\\pages\\admin\\company\\files\\index.vue' /* webpackChunkName: "pages/admin/company/files/index" */))
const _113d3d20 = () => interopDefault(import('..\\pages\\admin\\company\\onboarding\\index.vue' /* webpackChunkName: "pages/admin/company/onboarding/index" */))
const _2554e366 = () => interopDefault(import('..\\pages\\admin\\company\\polling\\index.vue' /* webpackChunkName: "pages/admin/company/polling/index" */))
const _49918cab = () => interopDefault(import('..\\pages\\admin\\company\\reprimand\\index.vue' /* webpackChunkName: "pages/admin/company/reprimand/index" */))
const _73507086 = () => interopDefault(import('..\\pages\\admin\\company\\task\\index.vue' /* webpackChunkName: "pages/admin/company/task/index" */))
const _29576941 = () => interopDefault(import('..\\pages\\admin\\company\\user_activity_log\\index.vue' /* webpackChunkName: "pages/admin/company/user_activity_log/index" */))
const _e8e76fe0 = () => interopDefault(import('..\\pages\\admin\\employees\\detail.vue' /* webpackChunkName: "pages/admin/employees/detail" */))
const _6951c982 = () => interopDefault(import('..\\pages\\admin\\finances\\cash.vue' /* webpackChunkName: "pages/admin/finances/cash" */))
const _531e2682 = () => interopDefault(import('..\\pages\\admin\\finances\\loan.vue' /* webpackChunkName: "pages/admin/finances/loan" */))
const _79e0f70e = () => interopDefault(import('..\\pages\\admin\\finances\\reimbursement.vue' /* webpackChunkName: "pages/admin/finances/reimbursement" */))
const _ae1d3e6e = () => interopDefault(import('..\\pages\\admin\\lapor\\detail.vue' /* webpackChunkName: "pages/admin/lapor/detail" */))
const _babb409e = () => interopDefault(import('..\\pages\\admin\\master\\masterCompanies.vue' /* webpackChunkName: "pages/admin/master/masterCompanies" */))
const _21d651c8 = () => interopDefault(import('..\\pages\\admin\\master\\masterEmployee.vue' /* webpackChunkName: "pages/admin/master/masterEmployee" */))
const _ea3b627a = () => interopDefault(import('..\\pages\\admin\\master\\masterPosition.vue' /* webpackChunkName: "pages/admin/master/masterPosition" */))
const _c3076450 = () => interopDefault(import('..\\pages\\admin\\master\\masterShift.vue' /* webpackChunkName: "pages/admin/master/masterShift" */))
const _0c389165 = () => interopDefault(import('..\\pages\\admin\\master\\masterUser.vue' /* webpackChunkName: "pages/admin/master/masterUser" */))
const _ab2259d0 = () => interopDefault(import('..\\pages\\admin\\time_management\\attendance.vue' /* webpackChunkName: "pages/admin/time_management/attendance" */))
const _2b2552ad = () => interopDefault(import('..\\pages\\admin\\time_management\\calendar.vue' /* webpackChunkName: "pages/admin/time_management/calendar" */))
const _f520d4f4 = () => interopDefault(import('..\\pages\\admin\\time_management\\schedule.vue' /* webpackChunkName: "pages/admin/time_management/schedule" */))
const _5dd14e31 = () => interopDefault(import('..\\pages\\admin\\time_management\\setting.vue' /* webpackChunkName: "pages/admin/time_management/setting" */))
const _6108bb3a = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff.vue' /* webpackChunkName: "pages/admin/time_management/timeoff" */))
const _29955889 = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff_deduction.vue' /* webpackChunkName: "pages/admin/time_management/timeoff_deduction" */))
const _279da039 = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))
>>>>>>> 09c4fba6b0fbbd44f893cb80d731ff2580e4b3ea

// TODO: remove in Nuxt 3
const emptyFn = () => {}
const originalPush = Router.prototype.push
Router.prototype.push = function push (location, onComplete = emptyFn, onAbort) {
  return originalPush.call(this, location, onComplete, onAbort)
}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: decodeURI('/'),
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/company_check",
    component: _947adda6,
    name: "company_check"
  }, {
    path: "/LandingPage",
    component: _14af2b4d,
    name: "LandingPage"
  }, {
    path: "/login",
    component: _1d757960,
    name: "login"
  }, {
    path: "/profile",
    component: _9fa2f460,
    name: "profile"
  }, {
    path: "/register",
    component: _acf558e8,
    name: "register"
  }, {
    path: "/register_account",
    component: _fef7ad0c,
    name: "register_account"
  }, {
    path: "/register_company",
    component: _2e9633ca,
    name: "register_company"
  }, {
    path: "/reset-password",
    component: _6124a282,
    name: "reset-password"
  }, {
    path: "/test",
    component: _a4352b0a,
    name: "test"
  }, {
    path: "/admin/beranda",
    component: _7015a133,
    name: "admin-beranda"
  }, {
    path: "/admin/berita",
    component: _22cad846,
    name: "admin-berita"
  }, {
    path: "/admin/company",
    component: _2f2b092a,
    name: "admin-company"
  }, {
    path: "/admin/company1",
    component: _495f5b8a,
    name: "admin-company1"
  }, {
    path: "/admin/employees",
    component: _62af43e3,
    name: "admin-employees"
  }, {
    path: "/admin/informasi",
    component: _5a357628,
    name: "admin-informasi"
  }, {
    path: "/admin/kegiatan",
    component: _06328992,
    name: "admin-kegiatan"
  }, {
    path: "/admin/lapor",
    component: _3a57b00a,
    name: "admin-lapor"
  }, {
    path: "/admin/permission",
    component: _7b984c97,
    name: "admin-permission"
  }, {
    path: "/admin/report",
    component: _ffe80d08,
    name: "admin-report"
  }, {
    path: "/admin/salary",
    component: _c12399dc,
    name: "admin-salary"
  }, {
    path: "/admin/shift",
    component: _1cd32c6a,
    name: "admin-shift"
  }, {
    path: "/admin/shiftEmployee",
    component: _36712238,
    name: "admin-shiftEmployee"
  }, {
    path: "/admin/test",
    component: _322afcc8,
    name: "admin-test"
  }, {
    path: "/admin/users",
    component: _717431c2,
    name: "admin-users"
  }, {
    path: "/admin/company/announcement",
    component: _7e950af8,
    name: "admin-company-announcement"
  }, {
    path: "/admin/company/asset",
    component: _1c4799d9,
    name: "admin-company-asset"
  }, {
    path: "/admin/company/document_template",
    component: _1fbf2a6b,
    name: "admin-company-document_template"
  }, {
    path: "/admin/company/files",
    component: _6666c01c,
    name: "admin-company-files"
  }, {
    path: "/admin/company/onboarding",
    component: _113d3d20,
    name: "admin-company-onboarding"
  }, {
    path: "/admin/company/polling",
    component: _2554e366,
    name: "admin-company-polling"
  }, {
    path: "/admin/company/reprimand",
    component: _49918cab,
    name: "admin-company-reprimand"
  }, {
    path: "/admin/company/task",
    component: _73507086,
    name: "admin-company-task"
  }, {
    path: "/admin/company/user_activity_log",
    component: _29576941,
    name: "admin-company-user_activity_log"
  }, {
    path: "/admin/employees/detail",
    component: _e8e76fe0,
    name: "admin-employees-detail"
  }, {
    path: "/admin/finances/cash",
    component: _6951c982,
    name: "admin-finances-cash"
  }, {
    path: "/admin/finances/loan",
    component: _531e2682,
    name: "admin-finances-loan"
  }, {
    path: "/admin/finances/reimbursement",
    component: _79e0f70e,
    name: "admin-finances-reimbursement"
  }, {
    path: "/admin/lapor/detail",
    component: _ae1d3e6e,
    name: "admin-lapor-detail"
  }, {
    path: "/admin/master/masterCompanies",
    component: _babb409e,
    name: "admin-master-masterCompanies"
  }, {
    path: "/admin/master/masterEmployee",
    component: _0a542a5a,
    name: "admin-master-masterEmployee"
  }, {
    path: "/admin/master/masterPosition",
    component: _ea3b627a,
    name: "admin-master-masterPosition"
  }, {
    path: "/admin/master/masterShift",
    component: _fa74e2f4,
    name: "admin-master-masterShift"
  }, {
    path: "/admin/master/masterUser",
    component: _0c389165,
    name: "admin-master-masterUser"
  }, {
    path: "/admin/time_management/attendance",
    component: _ab2259d0,
    name: "admin-time_management-attendance"
  }, {
    path: "/admin/time_management/calendar",
    component: _2b2552ad,
    name: "admin-time_management-calendar"
  }, {
    path: "/admin/time_management/schedule",
    component: _f520d4f4,
    name: "admin-time_management-schedule"
  }, {
    path: "/admin/time_management/setting",
    component: _5dd14e31,
    name: "admin-time_management-setting"
  }, {
    path: "/admin/time_management/timeoff",
    component: _6108bb3a,
    name: "admin-time_management-timeoff"
  }, {
    path: "/admin/time_management/timeoff_deduction",
    component: _29955889,
    name: "admin-time_management-timeoff_deduction"
  }, {
    path: "/",
    component: _279da039,
    name: "index"
  }],

  fallback: false
}

export function createRouter () {
  return new Router(routerOptions)
}
