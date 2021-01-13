<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Users</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row" style="padding-top:40px">
                    <div class="col-xl-3">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">
                                            User Aktif</h5>
                                        <span
                                            class="h2 font-weight-bold mb-0">{{numberWithCommas(getSummary.aktif)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">
                                            User Non Aktif</h5>
                                        <span
                                            class="h2 font-weight-bold mb-0">{{numberWithCommas(getSummary.non_aktif)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <div class="col-md-4 offset-md-2">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/user/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/user/download/xlsx`)">Download Excel</vs-button>
        </div>
                    </div>
      <el-card v-loading="getLoader">
        <div class="row" style="margin-bottom:20px">
          <div class="col-md-3 offset-md-9">
            <el-input placeholder="Cari" v-model="search" @change="searchData()" size="mini">
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
          </div>
        </div>
        <vs-table striped>
          <template #thead>
            <vs-tr>
              <vs-th>Action</vs-th>
              <vs-th>Aktif</vs-th>
              <vs-th>Name</vs-th>
              <vs-th>NIP</vs-th>
              <vs-th>Email</vs-th>
              <vs-th>Jabatan</vs-th>
              <vs-th>Pemda Prov/Kab/Kota</vs-th>
              <vs-th>Organisasi Daerah</vs-th>
              <vs-th>Unit Kerja</vs-th>
              <vs-th>No HP/WA</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getUsers.data" :data="tr">
              <vs-td>
                <el-tooltip content="Edit" placement="top-start" effect="dark">
                  <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                </el-tooltip>

                <el-tooltip content="Delete" placement="top-start" effect="dark">
                  <el-button size="mini" type="primary" @click="deleteUser(tr.id)" icon="fa fa-trash"></el-button>
                </el-tooltip>
              </vs-td>
              <vs-td>
                <span class="badge badge-success" v-if="tr.aktif">Aktif</span>
                <span class="badge badge-warning" v-else>Non Aktif</span>
              </vs-td>
              <vs-td>
                {{ tr.nama }}
              </vs-td>
              <vs-td>
                {{ tr.nip }}
              </vs-td>
              <vs-td>
                {{ tr.email }}
              </vs-td>
              <vs-td>
                {{ tr.jabatan }}
              </vs-td>
              <vs-td>
                <img v-if="tr.goverment" :src="tr.goverment.foto_url" height="20" width="auto">
                {{ tr.goverment ? tr.goverment.nama : '-' }}
              </vs-td>
              <vs-td>
                {{ tr.organisasi }}
              </vs-td>
              <vs-td>
                {{ tr.unit_kerja }}
              </vs-td>
              <vs-td>
                {{ tr.no_hp }}
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{getUsers.total}} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination v-model="page" :length="Math.ceil(getUsers.total / table.max)" />
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </el-card>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat User Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah User'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button-->

    <vs-dialog v-model="tambahDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()">
      <template #header>
        <h1 class="not-margin">
          {{titleDialog}}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Nama</label>
            <vs-input type="text" v-model="form.nama" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>NIP</label>
            <vs-input type="number" v-model="form.nip" placeholder="NIP"></vs-input>
          </vs-col>
          <vs-col v-if="form.level == 2" vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>No HP</label>
            <vs-input type="number" v-model="form.no_hp" placeholder="No HP"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Email</label>
            <vs-input v-model="form.email" placeholder="Email"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Jabatan</label>
            <vs-input type="text" v-model="form.jabatan" placeholder="Jabatan"></vs-input>
          </vs-col>
          <vs-col v-if="form.level == 2" vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Pemda Prov/Kab/Kota</label>
            <vs-select filter placeholder="Pemda Prov/Kab/Kota" v-model="form.id_goverment">
              <vs-option v-for="item in getGovermentPlains" :key="item.id" :label="item.nama" :value="item.id">
                {{item.nama}}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col v-if="form.level == 2" vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Organisasi</label>
            <vs-input type="text" v-model="form.organisasi" placeholder="Organisasi Daerah"></vs-input>
          </vs-col>
          <vs-col v-if="form.level == 2" vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Unit Kerja</label>
            <vs-input type="text" v-model="form.unit_kerja" placeholder="Unit Kerja"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Password</label>
            <vs-input type="password" v-model="form.password" placeholder="Password"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Konfirmasi Password</label>
            <vs-input type="password" v-model="form.konfirmasi_password" placeholder="Konfirmasi Password"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>User Level</label>
            <vs-select placeholder="Level" v-model="form.level">
              <vs-option value="1" label="1">1</vs-option>
              <vs-option value="2" label="2">2</vs-option>
            </vs-select>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <vs-row>
              <vs-col w="2">
                <label>Aktif</label>
              </vs-col>
              <vs-col w="10">
                <vs-switch style="width:20px" v-model="form.aktif" />
              </vs-col>
            </vs-row>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding:5px">
              <vs-button block :loading="btnLoader"  @click="confirmation('update')" v-if="isUpdate">Update</vs-button>
              <vs-button block :loading="btnLoader" @click="confirmation('store')" v-else>Simpan</vs-button>
            </vs-col>
            <vs-col w="6" style="padding:5px">
              <vs-button block border @click="tambahDialog = false; resetForm()">Batal</vs-button>
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
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
         page: 1,
        titleDialog: 'Tambah User',
        tambahDialog: false,
        search: '',
        isUpdate: false,
        btnLoader: false,
        form: {
          nama: "",
          email: "",
          nip: "",
          unit_kerja: "",
          jabatan: "",
          no_hp: "",
          id_goverment: '',
          konfirmasi_password: '',
          password: '',
          organisasi: "",
          aktif: true,
          level: 2,
          foto: null
        },
      }
    },
    mounted() {
      this.$store.dispatch('user/getAll', {
        showall: 1
      });
      this.$store.dispatch('goverment/getPlains', {
        showall: 0
      });
      this.$store.dispatch('user/getUserSummary');
    },
    methods: {
      searchData(){
        this.$store.dispatch('user/getAll', {
          search: this.search
        });
      },
      edit(data) {
        let form = JSON.parse(JSON.stringify(data))
        let searchGov = form.goverment ? form.goverment.nama : ''
        // this.$store.dispatch('goverment/getAll', {
        //   search: searchGov,
        //   showall: 0
        // });
        this.tambahDialog = true
        this.titleDialog = 'Edit User'
        this.isUpdate = true
        // setTimeout(() => {
        this.form = form
        // }, 1000)
      },
      resetForm() {
        this.form = {
          nama: "",
          email: "",
          nip: "",
          unit_kerja: "",
          jabatan: "",
          no_hp: "",
          id_goverment: '',
          organisasi: "",
          aktif: true,
          level: 2,
          foto: null,
          konfirmasi_password: '',
          password: '',
        }
        this.isUpdate = false
      },
      confirmation(type) {
        if (this.form.konfirmasi_password == this.form.password) {
          this.onSubmit(type)
        } else {
          // this.$notify.error({
          //   title: 'Konfirmasi Password',
          //   message: `Password Tidak Sama`
          // })
          this.openNotification('top-right', 'danger', `<i class='bx bxs-error-circle'></i>`, 'Konfirmasi Password', 'Password Tidak Sama')
        }
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let url = "/user/store";
        if (type == 'update') {
          url = `/user/${this.form.id}/update`
        }

        this.$axios.post(url, this.form).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} User`
            })
            this.tambahDialog = false
            this.resetForm()
            this.$store.dispatch('user/getAll', {});
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
      deleteUser(id) {
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
            this.$axios.delete(`/user/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('user/getAll', {
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
      handleChangeSelect(data) {
        this.$store.dispatch('goverment/getAll', {
          search: data,
          showall: 0
        });
      }
    },
    computed: {
      ...mapGetters("user", [
        'getUsers',
        'getLoader',
        'getSummary'
      ]),
      ...mapGetters("goverment", [
        'getGovermentPlains',
      ])
    },
    watch: {
      form: {
          handler(val){
            if(val.level == 1){
              this.form.id_goverment = '';
              this.form.unit_kerja = '-'
              // this.form.jabatan = '-'
              this.form.no_hp = "-"
              this.form.organisasi = "-"
            }
          },
          deep: true
      },
      page(newValue, oldValue) {
        this.$store.commit('user/setPage', newValue)
        this.$store.dispatch('user/getAll', {});
      }
    },
  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }

</style>
