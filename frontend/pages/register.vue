<template>
  <div class="card border-0">
    <div class="card-header bg-transparent logo" style="border: none">
      <a class="navbar-brand" style="margin-bottom: 20px">
        <img src="../assets/img/logo-simpulkendali.png" width="auto" height="100" />
      </a>
      <div class="text-center text-muted">
        - Daftar Akun -
      </div>
    </div>
    <div class="card-body">
      <form role="form" @submit.prevent="login()">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="Nama Lengkap" type="text">
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="NIP" type="text">
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="Email" type="text">
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <!-- <input class="form-control" name="username" required placeholder="Nama Pemda Prov/Kab/Kota" type="text"> -->
                <select class="form-control" placeholder="Nama Pemda Prov/Kab/Kota">
                        <option value="">- Pilih Pemda -</option>
                        <option v-for="item in kemementrian" :key="item.id" :label="item.judul" :value="item.judul">
                        </option>
                      </select>
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="Organisasi Perangkat Daerah"
                  type="text">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="Jabatan" type="text">
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="Unit Kerja" type="text">
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" name="username" required placeholder="No HP / Whatsapp" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"></span>
                </div>
                <input class="form-control" v-model="password" name="password" required placeholder="Password"
                  type="password">
              </div>
            </div>
          </div>
        </div>
        <div class="text-center">
          <!-- <button type="submit" class="btn btn-primary">Login</button> -->
          <el-button type="primary" :loading="showLoading" class="my-4" round native-type="submit">Register
          </el-button>
          <br>
          <router-link to="/login">
            <a href="#">Sudah punya akun?</a>
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    layout: 'register',
    data() {
      return {
        username: '',
        password: '',
        showLoading: false,
        errorMessage: '',
        selectKementrian: '',
        kemementrian: [{
              id: 1,
              judul: 'Kabupaten Aceh Barat',
              waktu_pelaksanaan: '01/10/2020 13:23:12',
              pelasksana_kegiatan: 123,
              active: true,
              url: 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Lambang_Kabupaten_Aceh_Barat.png/50px-Lambang_Kabupaten_Aceh_Barat.png'
            },
            {
                id: 2,
                judul: 'Kabupaten Aceh Barat Daya',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                active: true,
                url: 'https://id.wikipedia.org/wiki/Berkas:Lambang-abdya.jpg'
            },
            {
                id: 3,
                judul: 'Kabupaten Banyuasin',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                url: 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Lambang_Kabupaten_Banyuasin.gif/50px-Lambang_Kabupaten_Banyuasin.gif'
            },
            {
                id: 4,
                judul: 'Kabupaten Lahat',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                url: 'Kabupaten Lahat'
            },
            {
                id: 5,
                judul: 'Kabupaten Muara Enim',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                url: 'Kabupaten Muara Enim'
            },
            {
                id: 6,
                judul: 'Kabupaten Pringsewu',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                active: true,
                url: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kabupaten_Pringsewu.png/49px-Lambang_Kabupaten_Pringsewu.png'
            },
            {
                id: 7,
                judul: 'Kabupaten Bandung',
                waktu_pelaksanaan: '01/10/2020 13:23:12',
                pelasksana_kegiatan: 123,
                url: 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg/50px-Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg.png'
            }
        ]
      }
    },
    mounted() {
      // this.getCompany()
    },
    methods: {
      async login() {
        // this.showLoading = true;
        // try {
        //     await this.$auth.loginWith('local', {
        //         data: {
        //             "username": this.username,
        //             "password": this.password,
        //             "kd_comp": this.kd_comp
        //         }
        //     }).catch(e => {
        //         console.log(e);
        //         // this.errorMessage = e.response.data.message
        //         this.$notify.error({
        //             title: 'Error',
        //             message: e.response.data.message
        //         });
        //     });
        //     this.showLoading = false;
        //     if (this.$auth.loggedIn) {
        //         this.$notify.success({
        //             title: 'Berhasil Login',
        //             message: 'Selamat Datang! :)'
        //         });
        //         this.$router.push('/')
        //     }
        // } catch (e) {
        //     console.log(e)
        //     this.showLoading = false;
        // }
      }
    },
    watch: {
      username(newValue, oldValue) {
        this.errorMessage = '';
      },
      password(newValue, oldValue) {
        this.errorMessage = '';
      },
      kd_comp(newValue, oldValue) {
        console.log(newValue)
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
