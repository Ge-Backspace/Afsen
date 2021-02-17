<template>
  <div class="card border-0">
    <div class="bg-transparent logo" style="border: none">
      <a class="navbar-brand rounded mx-auto d-block" style="margin-bottom: 20px;">
        <img src="../assets/img/Afsen-Logo.png" width="200" height="200" />
      </a>

    </div>
    <div class="text-center text-muted mb-4">
        <small><b>Register Account</b></small>
      </div>
    <div class="card-body">
      <el-alert v-if="errorMessage !== ''" :title="errorMessage" type="error" class="mb-3" show-icon>
      </el-alert>
      <form role="form" @submit.prevent="register_account">
        <input type="hidden" v-model="data.company_id" name="company_id">
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.company_name" name="company_name" disabled placeholder="Company Name" type="text">
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.name" name="name" required placeholder="Name" type="text">
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.username" name="username" required placeholder="Userame" type="text">
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.email" name="email" required placeholder="Email" type="text">
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.password" name="password" required placeholder="Password" type="password">
          </div>
        </div>
        <div class="text-center">
          <el-button type="primary" :loading="showLoading" class="my-4" round native-type="submit"> Register
          </el-button>
          <br>
          <router-link to="/login">
            <a href="#">Sudah ada account?</a>
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  export default {
    layout: 'auth',
    mounted () {
      if(this.$store.state.company.company){
        let storeCompany = this.$store.state.company.company
        this.data.company_id = storeCompany.id
        this.data.company_name = storeCompany.name
        console.log([this.data.company_id, this.data.company_name])
      }
    },
    data() {
      return {
        data: {
          company_id: '',
          company_name: '',
          name: '',
          username: '',
          email: '',
          password: ''
        },
        showLoading: false,
        errorMessage: '',
      }
    },
    methods: {
      async register_account(){
        this.showLoading = true;
        this.$axios.post('/register_account', this.data)
        .then( response => {
          let data = response.data.data;
          this.$notify({
            title: 'Success'
          })
          this.$store.commit('user/setUsers', data)
          this.$router.push('/login')
        })
        .catch(e => {
          console.log(e.response.data.message);
          this.$notify.error({
            title: 'Error',
            message: e.response.data.message
          });
        }).finally(() => {
          this.showLoading = false;
        });
      }
    },
  }
</script>

<style scoped>
  .header {
    border-radius: 0;
  }

  .input-group {
    box-shadow: none;
  }

  .form-control,
  .input-group-text {
    background-color: #eee;
  }

  .input-group-text {
    border-bottom-left-radius: 40px;
    border-top-left-radius: 40px;
  }

  .form-control {
    border-bottom-right-radius: 40px;
    border-top-right-radius: 40px;
  }

  .card {
    box-shadow: none !important;
  }

</style>
