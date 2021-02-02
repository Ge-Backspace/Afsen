import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from '@nuxt/ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

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
const _cccb5084 = () => interopDefault(import('..\\pages\\admin\\permission\\cuti.vue' /* webpackChunkName: "pages/admin/permission/cuti" */))
const _503eebbb = () => interopDefault(import('..\\pages\\admin\\permission\\shift.vue' /* webpackChunkName: "pages/admin/permission/shift" */))
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
const _2835089a = () => interopDefault(import('..\\pages\\admin\\master\\MasterCuti.vue' /* webpackChunkName: "pages/admin/master/MasterCuti" */))
const _0a542a5a = () => interopDefault(import('..\\pages\\admin\\master\\masterEmployee.vue' /* webpackChunkName: "pages/admin/master/masterEmployee" */))
const _73602755 = () => interopDefault(import('..\\pages\\admin\\master\\masterPosition.vue' /* webpackChunkName: "pages/admin/master/masterPosition" */))
const _fa74e2f4 = () => interopDefault(import('..\\pages\\admin\\master\\masterShift.vue' /* webpackChunkName: "pages/admin/master/masterShift" */))
const _1f5fa5ad = () => interopDefault(import('..\\pages\\admin\\master\\MasterStatusPermission.vue' /* webpackChunkName: "pages/admin/master/MasterStatusPermission" */))
const _1ae4fa12 = () => interopDefault(import('..\\pages\\admin\\master\\masterUser.vue' /* webpackChunkName: "pages/admin/master/masterUser" */))
const _17fb85c6 = () => interopDefault(import('..\\pages\\admin\\time_management\\attendance.vue' /* webpackChunkName: "pages/admin/time_management/attendance" */))
const _77fad8db = () => interopDefault(import('..\\pages\\admin\\time_management\\calendar.vue' /* webpackChunkName: "pages/admin/time_management/calendar" */))
const _5b75c898 = () => interopDefault(import('..\\pages\\admin\\time_management\\schedule.vue' /* webpackChunkName: "pages/admin/time_management/schedule" */))
const _1e3b4a43 = () => interopDefault(import('..\\pages\\admin\\time_management\\setting.vue' /* webpackChunkName: "pages/admin/time_management/setting" */))
const _e034c316 = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff.vue' /* webpackChunkName: "pages/admin/time_management/timeoff" */))
const _5a6e33ca = () => interopDefault(import('..\\pages\\admin\\time_management\\timeoff_deduction.vue' /* webpackChunkName: "pages/admin/time_management/timeoff_deduction" */))
const _65f98ecb = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))

// TODO: remove in Nuxt 3
const emptyFn = () => {}
const originalPush = Router.prototype.push
Router.prototype.push = function push (location, onComplete = emptyFn, onAbort) {
  return originalPush.call(this, location, onComplete, onAbort)
}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/company_check",
    component: _d1506482,
    name: "company_check"
  }, {
    path: "/LandingPage",
    component: _192e645f,
    name: "LandingPage"
  }, {
    path: "/login",
    component: _2fa131e2,
    name: "login"
  }, {
    path: "/profile",
    component: _716dd03c,
    name: "profile"
  }, {
    path: "/register",
    component: _75bd03ba,
    name: "register"
  }, {
    path: "/register_account",
    component: _535068b0,
    name: "register_account"
  }, {
    path: "/register_company",
    component: _f72c5410,
    name: "register_company"
  }, {
    path: "/reset-password",
    component: _9b920fa0,
    name: "reset-password"
  }, {
    path: "/test",
    component: _a02f3cae,
    name: "test"
  }, {
    path: "/admin/beranda",
    component: _7db0123e,
    name: "admin-beranda"
  }, {
    path: "/admin/berita",
    component: _5fa05f22,
    name: "admin-berita"
  }, {
    path: "/admin/company",
    component: _03e9f406,
    name: "admin-company"
  }, {
    path: "/admin/company1",
    component: _1a97bb9c,
    name: "admin-company1"
  }, {
    path: "/admin/employees",
    component: _db511c16,
    name: "admin-employees"
  }, {
    path: "/admin/informasi",
    component: _9fedcf54,
    name: "admin-informasi"
  }, {
    path: "/admin/kegiatan",
    component: _512a2cb8,
    name: "admin-kegiatan"
  }, {
    path: "/admin/lapor",
    component: _0d4491c8,
    name: "admin-lapor"
  }, {
    path: "/admin/permission",
    component: _7b984c97,
    name: "admin-permission",
    children: [{
      path: "cuti",
      component: _cccb5084,
      name: "admin-permission-cuti"
    }, {
      path: "shift",
      component: _503eebbb,
      name: "admin-permission-shift"
    }]
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
    component: _4960116c,
    name: "admin-shiftEmployee"
  }, {
    path: "/admin/test",
    component: _36aa35da,
    name: "admin-test"
  }, {
    path: "/admin/users",
    component: _0647ca20,
    name: "admin-users"
  }, {
    path: "/admin/company/announcement",
    component: _04bf1d96,
    name: "admin-company-announcement"
  }, {
    path: "/admin/company/asset",
    component: _13436707,
    name: "admin-company-asset"
  }, {
    path: "/admin/company/document_template",
    component: _3dfaa299,
    name: "admin-company-document_template"
  }, {
    path: "/admin/company/files",
    component: _786f25c0,
    name: "admin-company-files"
  }, {
    path: "/admin/company/onboarding",
    component: _453ca102,
    name: "admin-company-onboarding"
  }, {
    path: "/admin/company/polling",
    component: _4c921d14,
    name: "admin-company-polling"
  }, {
    path: "/admin/company/reprimand",
    component: _d331da4e,
    name: "admin-company-reprimand"
  }, {
    path: "/admin/company/task",
    component: _182f4598,
    name: "admin-company-task"
  }, {
    path: "/admin/company/user_activity_log",
    component: _4792e16f,
    name: "admin-company-user_activity_log"
  }, {
    path: "/admin/employees/detail",
    component: _50e9dc3e,
    name: "admin-employees-detail"
  }, {
    path: "/admin/finances/cash",
    component: _7ef25414,
    name: "admin-finances-cash"
  }, {
    path: "/admin/finances/loan",
    component: _27dd115e,
    name: "admin-finances-loan"
  }, {
    path: "/admin/finances/reimbursement",
    component: _2b6683b2,
    name: "admin-finances-reimbursement"
  }, {
    path: "/admin/lapor/detail",
    component: _6aa78812,
    name: "admin-lapor-detail"
  }, {
    path: "/admin/master/masterCompanies",
    component: _6c40cd42,
    name: "admin-master-masterCompanies"
  }, {
    path: "/admin/master/MasterCuti",
    component: _2835089a,
    name: "admin-master-MasterCuti"
  }, {
    path: "/admin/master/masterEmployee",
    component: _0a542a5a,
    name: "admin-master-masterEmployee"
  }, {
    path: "/admin/master/masterPosition",
    component: _73602755,
    name: "admin-master-masterPosition"
  }, {
    path: "/admin/master/masterShift",
    component: _fa74e2f4,
    name: "admin-master-masterShift"
  }, {
    path: "/admin/master/MasterStatusPermission",
    component: _1f5fa5ad,
    name: "admin-master-MasterStatusPermission"
  }, {
    path: "/admin/master/masterUser",
    component: _1ae4fa12,
    name: "admin-master-masterUser"
  }, {
    path: "/admin/time_management/attendance",
    component: _17fb85c6,
    name: "admin-time_management-attendance"
  }, {
    path: "/admin/time_management/calendar",
    component: _77fad8db,
    name: "admin-time_management-calendar"
  }, {
    path: "/admin/time_management/schedule",
    component: _5b75c898,
    name: "admin-time_management-schedule"
  }, {
    path: "/admin/time_management/setting",
    component: _1e3b4a43,
    name: "admin-time_management-setting"
  }, {
    path: "/admin/time_management/timeoff",
    component: _e034c316,
    name: "admin-time_management-timeoff"
  }, {
    path: "/admin/time_management/timeoff_deduction",
    component: _5a6e33ca,
    name: "admin-time_management-timeoff_deduction"
  }, {
    path: "/",
    component: _65f98ecb,
    name: "index"
  }],

  fallback: false
}

function decodeObj(obj) {
  for (const key in obj) {
    if (typeof obj[key] === 'string') {
      obj[key] = decode(obj[key])
    }
  }
}

export function createRouter () {
  const router = new Router(routerOptions)

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    const r = resolve(to, current, append)
    if (r && r.resolved && r.resolved.query) {
      decodeObj(r.resolved.query)
    }
    return r
  }

  return router
}
