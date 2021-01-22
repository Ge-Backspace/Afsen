import Vue from 'vue'
import Router from 'vue-router'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

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
const _4e184dca = () => interopDefault(import('..\\pages\\admin\\notifikasi.vue' /* webpackChunkName: "pages/admin/notifikasi" */))
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
const _ea3b627a = () => interopDefault(import('..\\pages\\admin\\master\\masterPosition.vue' /* webpackChunkName: "pages/admin/master/masterPosition" */))
const _63c03d9e = () => interopDefault(import('..\\pages\\admin\\master\\masterSchedule.vue' /* webpackChunkName: "pages/admin/master/masterSchedule" */))
const _0c389165 = () => interopDefault(import('..\\pages\\admin\\master\\masterUser.vue' /* webpackChunkName: "pages/admin/master/masterUser" */))
const _ab2259d0 = () => interopDefault(import('..\\pages\\admin\\time_management\\attendance.vue' /* webpackChunkName: "pages/admin/time_management/attendance" */))
const _2b2552ad = () => interopDefault(import('..\\pages\\admin\\time_management\\calendar.vue' /* webpackChunkName: "pages/admin/time_management/calendar" */))
const _f520d4f4 = () => interopDefault(import('..\\pages\\admin\\time_management\\schedule.vue' /* webpackChunkName: "pages/admin/time_management/schedule" */))
const _5dd14e31 = () => interopDefault(import('..\\pages\\admin\\time_management\\setting.vue' /* webpackChunkName: "pages/admin/time_management/setting" */))
const _6108bb3a = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff.vue' /* webpackChunkName: "pages/admin/time_management/timeoff" */))
const _29955889 = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff_deduction.vue' /* webpackChunkName: "pages/admin/time_management/timeoff_deduction" */))
const _279da039 = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))

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
    path: "/admin/notifikasi",
    component: _4e184dca,
    name: "admin-notifikasi"
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
    path: "/admin/master/masterPosition",
    component: _ea3b627a,
    name: "admin-master-masterPosition"
  }, {
    path: "/admin/master/masterSchedule",
    component: _63c03d9e,
    name: "admin-master-masterSchedule"
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
