<template>
  <div class="card border-0">
    <div class="bg-transparent logo" style="border: none">
      <a class="navbar-brand rounded mx-auto d-block" style="margin-bottom: 20px;">
        <img src="../assets/img/Afsen-Logo.png" width="200" height="200" />
      </a>

    </div>
    <div class="text-center text-muted mb-4">
        - Check Company -
      </div>
    <div class="card-body">
      <el-alert v-if="errorMessage !== ''" :title="errorMessage" type="error" class="mb-3" show-icon>
      </el-alert>
      <form role="form" @submit.prevent="company_check">
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text"></span>
            </div>
            <input class="form-control" v-model="data.company_name" name="name" required placeholder="Company Name" type="text">
          </div>
        </div>
        <div class="text-center">
          <el-button type="primary" :loading="showLoading" class="my-4" round native-type="submit"> Check
          </el-button>
          <br>
          <router-link to="/register_company">
            <a href="#">Belum ada company?</a>
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
    data() {
      return {
        data: {
          company_name: '',
          // lat: '',
          // lng: '',
        },
        showLoading: false,
        errorMessage: '',
      }
    },
    mounted() {
      // this.$getLocation({})
      // .then(coordinates => {
      //   this.data.lat = coordinates.lat;
      //   this.data.lng = coordinates.lng;
      // });
    },
    methods: {
      async company_check(){
        this.showLoading = true;
        this.$axios.post('/company_check', this.data)
        .then( response => {
          let data = response.data.data;
          this.$store.commit('company/setCompanyR', data)
          this.$router.push('/register_account')
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
