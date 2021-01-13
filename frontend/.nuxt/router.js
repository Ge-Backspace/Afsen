import Vue from 'vue'
import Router from 'vue-router'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _2593858c = () => interopDefault(import('..\\pages\\company_check.vue' /* webpackChunkName: "pages/company_check" */))
const _0db7f2a2 = () => interopDefault(import('..\\pages\\login.vue' /* webpackChunkName: "pages/login" */))
const _3b69ed6f = () => interopDefault(import('..\\pages\\profile.vue' /* webpackChunkName: "pages/profile" */))
const _a46c368a = () => interopDefault(import('..\\pages\\register_account.vue' /* webpackChunkName: "pages/register_account" */))
const _5bdbef0b = () => interopDefault(import('..\\pages\\register_company.vue' /* webpackChunkName: "pages/register_company" */))
const _291b8bfa = () => interopDefault(import('..\\pages\\reset-password.vue' /* webpackChunkName: "pages/reset-password" */))
const _19813f3c = () => interopDefault(import('..\\pages\\test.vue' /* webpackChunkName: "pages/test" */))
const _0b398e98 = () => interopDefault(import('..\\pages\\admin\\beranda.vue' /* webpackChunkName: "pages/admin/beranda" */))
const _5e6b883c = () => interopDefault(import('..\\pages\\admin\\berita.vue' /* webpackChunkName: "pages/admin/berita" */))
const _f1099d2e = () => interopDefault(import('..\\pages\\admin\\informasi.vue' /* webpackChunkName: "pages/admin/informasi" */))
const _74d03b9e = () => interopDefault(import('..\\pages\\admin\\kegiatan.vue' /* webpackChunkName: "pages/admin/kegiatan" */))
const _bfdcbdae = () => interopDefault(import('..\\pages\\admin\\lapor\\index.vue' /* webpackChunkName: "pages/admin/lapor/index" */))
const _f4d894fa = () => interopDefault(import('..\\pages\\admin\\users.vue' /* webpackChunkName: "pages/admin/users" */))
const _0b14d8ec = () => interopDefault(import('..\\pages\\admin\\lapor\\detail.vue' /* webpackChunkName: "pages/admin/lapor/detail" */))
const _66bea66e = () => interopDefault(import('..\\pages\\admin\\master\\pemda.vue' /* webpackChunkName: "pages/admin/master/pemda" */))
const _0fc35b69 = () => interopDefault(import('..\\pages\\admin\\master\\setting.vue' /* webpackChunkName: "pages/admin/master/setting" */))
const _2f7c6398 = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))

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
    component: _2593858c,
    name: "company_check"
  }, {
    path: "/login",
    component: _0db7f2a2,
    name: "login"
  }, {
    path: "/profile",
    component: _3b69ed6f,
    name: "profile"
  }, {
    path: "/register_account",
    component: _a46c368a,
    name: "register_account"
  }, {
    path: "/register_company",
    component: _5bdbef0b,
    name: "register_company"
  }, {
    path: "/reset-password",
    component: _291b8bfa,
    name: "reset-password"
  }, {
    path: "/test",
    component: _19813f3c,
    name: "test"
  }, {
    path: "/admin/beranda",
    component: _0b398e98,
    name: "admin-beranda"
  }, {
    path: "/admin/berita",
    component: _5e6b883c,
    name: "admin-berita"
  }, {
    path: "/admin/informasi",
    component: _f1099d2e,
    name: "admin-informasi"
  }, {
    path: "/admin/kegiatan",
    component: _74d03b9e,
    name: "admin-kegiatan"
  }, {
    path: "/admin/lapor",
    component: _bfdcbdae,
    name: "admin-lapor"
  }, {
    path: "/admin/users",
    component: _f4d894fa,
    name: "admin-users"
  }, {
    path: "/admin/lapor/detail",
    component: _0b14d8ec,
    name: "admin-lapor-detail"
  }, {
    path: "/admin/master/pemda",
    component: _66bea66e,
    name: "admin-master-pemda"
  }, {
    path: "/admin/master/setting",
    component: _0fc35b69,
    name: "admin-master-setting"
  }, {
    path: "/",
    component: _2f7c6398,
    name: "index"
  }],

  fallback: false
}

export function createRouter () {
  return new Router(routerOptions)
}
