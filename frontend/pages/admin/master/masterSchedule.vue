<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Schedule</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
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
                  <vs-th>Hari</vs-th>
                  <vs-th>Schedule In</vs-th>
                  <vs-th>Schedule Out</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getSchedule.data" :data="tr">
                  <vs-td>
                    {{ tr.hari }}
                  </vs-td>
                  <vs-td>
                    {{ tr.schedule_in }}
                  </vs-td>
                  <vs-td>
                    {{ tr.schedule_out }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteSchedule(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getSchedule.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getSchedule.total / table.max)" />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Schedule Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Schedule'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button -->

    <el-dialog :title="titleDialog" :visible.sync="tambahDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'" @closed="resetForm()">
      <el-form label-width="auto" ref="form" :model="form" size="mini">
        <el-form-item label="Hari">
          <el-input v-model="form.hari"></el-input>
        </el-form-item>
        <el-form-item label="Schedule In">
          <el-time-picker v-model="form.schedule_in"></el-time-picker>
        </el-form-item>
        <el-form-item size="large">
          <el-button type="primary" :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</el-button>
          <el-button type="primary" :loading="btnLoader" @click="onSubmit" v-else>Simpan</el-button>
          <el-button @click="tambahDialog = false">Batal</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

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
            <vs-input type="text" v-model="form.name" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Address</label>
            <vs-input type="text" v-model="form.address" placeholder="Address"></vs-input>
          </vs-col>
          <el-form-item label="Schedule In" >
          <el-time-picker v-model="form.schedule_in"></el-time-picker>
        </el-form-item>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding:5px">
              <vs-button block :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</vs-button>
              <vs-button block :loading="btnLoader" @click="onSubmit('store')" v-else>Simpan</vs-button>
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

  import {
    config
  } from '../../../global.config'

  export default {
    layout: 'admin',
    components: {

    },
    data() {
      return {
        api_url: config.baseApiUrl,
        table: {
          max: 10
        },
        page: 1,
        titleDialog: '',
        search: '',
        company_id : JSON.parse(JSON.stringify(this.$auth.user.company_id)),
        isUpdate: false,
        tambahDialog: false,
        btnLoader: false,
        form: {
          id: '',
          hari: '',
          urut: '',
          schedule_in: '',
          schedule_out: '',
        }
      }
    },
    mounted() {
      this.$store.dispatch('schedule/getAll', {
        company_id: this.company_id
      });
    },
    methods: {
      searchData(){
        this.$store.dispatch('schedule/getAll', {
          search: this.search,
          company_id: this.company_id
        });
      },
      edit(data) {
        this.form.id = data.id
        this.tambahDialog = true
        this.titleDialog = 'Edit Schedule'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          name: '',
          address: '',
        }
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('schedule/setPage', val)
        this.$store.dispatch('schedule/getAll', {
          company_id: this.company_id
        });
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("name", this.form.name)
        formData.append("address", this.form.address)
        let url = "/schedule/store";
        if (type == 'update') {
          url = `/schedule/update/${this.form.id}`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Schedule`
            })
            this.resetForm()
            this.tambahDialog = false
            this.$store.dispatch('schedule/getAll', {
              company_id: this.company_id
            });
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
      deleteSchedule(id) {
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
            this.$axios.delete(`/schedule/delete/${id}`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('schedule/getAll', {
                  defaultPage: true,
                  company_id: this.company_id
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
      }
    },
    computed: {
      ...mapGetters("schedule", [
        'getSchedule',
        'getLoader'
      ])
    },
    watch: {
      getSchedule(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('goverment/getAll', {
        //   search: newValue
        // });
      },
      page(newValue, oldValue) {
        this.$store.commit('schedule/setPage', newValue)
        this.$store.dispatch('schedule/getAll', {
          company_id: this.company_id
        });
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
