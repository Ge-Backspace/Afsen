<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Shift</h1>
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
                  <vs-th>Name</vs-th>
                  <vs-th>Code</vs-th>
                  <vs-th>Schedule In</vs-th>
                  <vs-th>Schedule Out</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getShifts.data" :data="tr">
                  <vs-td>
                    {{ tr.shift_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.code }}
                  </vs-td>
                  <vs-td>
                    {{ formatTime(tr.schedule_in) }}
                  </vs-td>
                  <vs-td>
                    {{ formatTime(tr.schedule_out) }}
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
                    <small>Total : {{getShifts.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getShifts.total / table.max)" />
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
      <a class="float" @click="shiftDialog = true; titleDialog = 'Tambah Shift'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button -->

    <!-- <el-dialog :title="titleDialog" :visible.sync="shiftDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'" @closed="resetForm()">
      <el-form label-width="auto" ref="form" :model="form" size="mini">
        <el-form-item label="Hari">
          <el-input v-model="form.hari"></el-input>
        </el-form-item>
        <el-form-item label="Schedule In">
          <el-time-picker v-model="form.schedule_out"></el-time-picker>
        </el-form-item>
        <el-form-item size="large">
          <el-button type="primary" :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</el-button>
          <el-button type="primary" :loading="btnLoader" @click="onSubmit" v-else>Simpan</el-button>
          <el-button @click="shiftDialog = false">Batal</el-button>
        </el-form-item>
      </el-form>
    </el-dialog> -->

    <vs-dialog v-model="shiftDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
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
            <vs-input type="text" v-model="form.shift_name" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Code</label>
            <vs-input type="text" v-model="form.code" placeholder="Code"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Schedule_in</label>
            <vs-input type="time" v-model="form.schedule_in" placeholder="Schedule_in"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Schedule_out</label>
            <vs-input type="time" v-model="form.schedule_out" placeholder="Schedule_out"></vs-input>
          </vs-col>
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
              <vs-button block border @click="shiftDialog = false; resetForm()">Batal</vs-button>
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
        company_id: '',
        table: {
          max: 10
        },
        page: 1,
        titleDialog: 'Edit Company',
        search: '',
        company_id : JSON.parse(JSON.stringify(this.$auth.user.company_id)),
        isUpdate: false,
        shiftDialog: false,
        btnLoader: false,
        form: {
          id: '',
          shift_name: '',
          code: '',
          schedule_in: '',
          schedule_out: '',
        }
      }
    },
    mounted() {
      this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
      this.$store.dispatch('shift/getAll', {
        company_id: this.company_id
      });
    },
    methods: {
      searchData(){
        this.$store.dispatch('shift/getAll', {
          search: this.search,
          company_id: this.company_id
        });
      },
      edit(data) {
        // console.log(moment(data.schedule_in,"HH:mm:ss").format("HH:mm"))
        this.form.id = data.id
        this.form.shift_name = data.shift_name
        this.form.code = data.code
        this.form.schedule_in = data.schedule_in
        this.form.schedule_out = data.schedule_out
        this.shiftDialog = true
        this.titleDialog = 'Edit Shift Data'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          id: '',
          shift_name: '',
          code: '',
          schedule_in: '',
          schedule_out: ''
        }
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('shift/setPage', val)
        this.$store.dispatch('shift/getAll', {
          company_id: this.company_id
        });
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("id", this.form.id)
        formData.append("company_id", this.company_id)
        formData.append("shift_name", this.form.shift_name)
        formData.append("code", this.form.code)
        formData.append("schedule_in", this.form.schedule_in)
        formData.append("schedule_out", this.form.schedule_out)
        let url = "/shift";
        if (type == 'update') {
          url = `/shift/update/${this.form.id}`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Shift`
            })
            this.resetForm()
            this.shiftDialog = false
            this.$store.dispatch('shift/getAll', {
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
          title: 'HEY WAIT!, HEY HOLD ON!',
          text: "Are you serious to delete this cutie data ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes Yes Yes',
          cancelButtonText: 'Yes but actually NO!'
        }).then((result) => {
          if (result.isConfirmed) {
            this.$axios.delete(`/shift/delete/${id}`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.shiftDialog = false
                this.$store.dispatch('shift/getAll', {
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
      },
      formatTime(time){
        return moment(time, "HH:mm:ss").format('HH:mm');
      }
    },
    computed: {
      ...mapGetters('shift', [
        'getShifts',
        'getLoader'
      ])
    },
    watch: {
      getShifts(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        this.$store.dispatch('goverment/getAll', {
          search: newValue
        });
      },
      page(newValue, oldValue) {
        this.$store.commit('shift/setPage', newValue)
        this.$store.dispatch('shift/getAll', {
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
