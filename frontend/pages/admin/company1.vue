<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Company</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <el-card v-loading="getLoader" style="margin-top: 120px">
        <div class="row">
          <div class="col-xl-4">
            <router-link to="/company/asset">
              <vs-card type="4">
                <template #title>
                  <h3>Asset</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Reprimand">
              <vs-card type="4">
                <template #title>
                  <h3>Reprimand</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Task">
              <vs-card type="4">
                <template #title>
                  <h3>Task</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Announcement">
              <vs-card type="4">
                <template #title>
                  <h3>Announcement</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/User_Activity_Log">
              <vs-card type="4">
                <template #title>
                  <h3>User Activity Log</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Document_Template">
              <vs-card type="4">
                <template #title>
                  <h3>Document Template</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Onboarding">
              <vs-card type="4">
                <template #title>
                  <h3>Onboarding</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Files">
              <vs-card type="4">
                <template #title>
                  <h3>Files</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          <div class="col-xl-4">
            <router-link to="/company/Polling">
              <vs-card type="4">
                <template #title>
                  <h3>Polling</h3>
                </template>
                <template #img>
                  <img src="../../assets/img/theme/angular.jpg" alt="">
                </template>
                <template #text>
                  <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                  </p>
                </template> 
              </vs-card>
            </router-link>
          </div>
          
        </div>
      </el-card>
    </div>    
  </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  export default {
    layout: 'admin',
    components: {

    },
    data() {
      return {
        table: {
          max: 10
        },
        toUrl: '/',
        page: 1,
        titleDialog: 'Tambah Informasi',
        tambahDialog: false,
        search: '',
        isUpdate: false,
        btnLoader: false,
        form: {
          judul: '',
          deskripsi: '',
          aktif: true
        }
      }
    },
    mounted() {
      this.$store.dispatch('informasi/getAll', {});
    },
    methods: {
      searchData() {
        this.$store.dispatch('informasi/getAll', {
          search: this.search
        });
      },
      edit(data) {
        this.form = JSON.parse(JSON.stringify(data))
        this.tambahDialog = true
        this.titleDialog = 'Edit Informasi'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
            judul: '',
            deskripsi: '',
            aktif: true
          },
          this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('informasi/setPage', val)
        this.$store.dispatch('informasi/getAll', {});
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let url = "/information/store";
        if (type == 'update') {
          url = `/information/${this.form.id}/update`
        }

        this.$axios.post(url, this.form).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Informasi`
            })
            this.tambahDialog = false
            this.$store.dispatch('informasi/getAll', {});
            this.resetForm()
          }
        }).finally(() => {
          this.btnLoader = false
        }).catch(err => {
          let error = err.response.data.data
          if (error) {
            this.showErrorField(error)
          } else {
            this.$notify.error({
              title: 'Error',
              message: err.response.data.message
            })
          }
        })
      },
      deleteInformasi(id) {
        this.$swal({
          title: 'Perhatian!',
          text: "Apakah anda yakin ingin menghapus data ini?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            this.$axios.delete(`/information/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('informasi/getAll', {
                  defaultPage: true
                });
              }
            }).finally(() => {
              //
            }).catch(err => {
              this.$notify.error({
                title: 'Error',
                message: err.response.data.message
              })
            })
          }
        })
      },
    },
    computed: {
      ...mapGetters("informasi", [
        'getInformations',
        'getLoader'
      ]),
    },
    watch: {
      getInformations(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('informasi/getAll', {
        //   search: newValue
        // });
      },
      page(newValue, oldValue) {
        this.$store.commit('berita/setPage', newValue)
        this.$store.dispatch('berita/getAll', {});
      }
    }
  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }

</style>
