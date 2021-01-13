<template>
  <div class="bg-primary container-fluid container-reset">
    <el-card class="card-reset">
      <div class="row">
        <div class="col-md-5">
          <div class="text-center">
            <img src="../assets/img/logo-simpulkendali.png" width="auto" height="100" />
            <h1>Simpul Kendali</h1>
            <h5>Badan Pengelolaan Ideologi Pancasila</h5>
          </div>
        </div>
        <div class="col-md-1" style="border-left: 1px solid #eee"></div>
        <div class="col-md-6 text-center">
          <h1>Reset Password</h1>
          <vs-input type="password" v-model="form.password" placeholder="Password Baru">
            <template #icon>
              <i class='bx bx-lock-open-alt'></i>
            </template>
          </vs-input>
          <vs-input type="password" v-model="form.password_confirmation" placeholder="Konfirmasi Password"
            style="margin-top:10px">
            <template #icon>
              <i class='bx bx-lock-open-alt'></i>
            </template>
          </vs-input>
          <vs-button block style="margin-top:10px" @click="resetPassword()" :loading="btnLoader">Reset</vs-button>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        btnLoader: false,
        form: {
          password: '',
          password_confirmation: '',
          email: '',
          token: ''
        }
      }
    },
    mounted () {
        this.form.token = this.$route.query.token;
        this.form.email = this.$route.query.email
    },
    methods: {
      resetPassword() {
        if (this.form.password_confirmation == this.form.password && this.form.password !== '' && this.form
          .password_confirmation !== '') {
          this.onSubmit()
        } else {
          if (this.form.password !== '' && this.form.password_confirmation !== '') {
            this.openNotification('top-right', 'danger', `<i class='bx bxs-error-circle'></i>`, 'Konfirmasi Password',
              'Password Tidak boleh kosong')
          } else {
            this.openNotification('top-right', 'danger', `<i class='bx bxs-error-circle'></i>`, 'Konfirmasi Password',
              'Password Tidak Sama')
          }
        }
      },
      onSubmit() {
        this.btnLoader = true
        this.$axios.post('/password/reset', this.form).then(resp => {
            if(resp.data.success){
                this.$notify.success({
                    title: 'Success',
                    message: resp.data.message
                })
            } else {
                this.$notify.error({
                    title: 'Error',
                    message: resp.data.message
                })
            }
        }).finally(() => {
          this.btnLoader = false
        }).catch(err => {
          let error = err.response.data.data
          if (error) {
            this.showErrorField(error)
          } else {
            error = err.response.data
            for (let key in error) {
              setTimeout(() => {
                this.openNotification('top-right', 'danger', `<i class='bx bxs-error-circle'></i>`, key,
                  error[key][0])
              }, error)
            }
          }
        })
      }
    },
  }

</script>

<style lang="scss" scoped>
  .container-reset {
    height: 100vh;
    padding-top: 10%;
    padding-right: 20%;
    padding-left: 20%;
  }

</style>
