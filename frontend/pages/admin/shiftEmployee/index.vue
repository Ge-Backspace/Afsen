<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Shift Employee</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/xlsx`)">Download Excel</vs-button>
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
              <vs-th>Employee</vs-th>
              <vs-th>Code</vs-th>
              <vs-th>Shift</vs-th>
              <vs-th>Schedule In</vs-th>
              <vs-th>Schedule Out</vs-th>
              <vs-th>Date</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getSE.data" :data="tr">
              <vs-td>
                {{ tr.name }}
              </vs-td>
              <vs-td>
                {{ tr.code }}
              </vs-td>
              <vs-td>
                {{ tr.shift_name }}
              </vs-td>
              <vs-td>
                {{ tr.schedule_in }}
              </vs-td>
              <vs-td>
                {{ tr.schedule_out }}
              </vs-td>
              <vs-td>
                {{ tr.date }}
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getSE.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getSE.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
        </vs-table>
      </el-card>
    </div>

    <el-tooltip class="item" effect="dark" content="Buat Shift Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Pemerintah Daerah'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog v-model="positionDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
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
            <vs-input type="text" v-model="form.position_name" placeholder="Position Name"></vs-input>
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
              <vs-button block border @click="positionDialog = false; resetForm()">Batal</vs-button>
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

import { config } from "../../../global.config";

export default {
  layout: "admin",
  components: {},
  data() {
    return {
      api_url: config.baseApiUrl,
      table: {
        max: 10,
      },
      request:false,
      page: 1,
      titleDialog: 'Edit Shift Employee',
      search: '',
      company_id: '',
      isUpdate: false,
      positionDialog: false,
      btnLoader: false,
      form: {

      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("shiftemployee/getAll", {
      company_id: this.company_id,
    });
  },
  methods: {
    // searchData(){
    //   this.$store.dispatch('schedule/getAll', {
    //     search: this.search,
    //     company_id: this.company_id
    //   });
    // },
    edit(data) {
      // console.log(moment(data.schedule_in,"HH:mm:ss").format("HH:mm"))
      this.form.id = data.id
      this.form.position_name = data.position_name
      this.form.group = data.group
      this.positionDialog = true
      this.titleDialog = 'Edit Position Data'
      this.isUpdate = true
    },
    resetForm() {
      this.form = {
        id: '',
        position_name: '',
        group: '',
      }
      this.isUpdate = false
    },
    // handleCurrentChange(val) {
    //   this.$store.commit('position/setPage', val)
    //   this.$store.dispatch('position/getAll', {
    //     company_id: this.company_id
    //   });
    // },
    // onSubmit(type = 'store') {
    //   this.btnLoader = true
    //   let formData = new FormData()
    //   // formData.append("id", this.form.id)
    //   formData.append("company_id", this.company_id)
    //   formData.append("position_name", this.form.position_name)
    //   formData.append("group", this.form.group)
    //   let url = "/position";
    //   if (type == 'update') {
    //     url = `/position/${this.form.id}`
    //   }

    //   this.$axios.post(url, formData).then(resp => {
    //     if (resp.data.success) {
    //       this.$notify.success({
    //         title: 'Success',
    //         message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Position`
    //       })
    //       this.resetForm()
    //       this.positionDialog = false
    //       this.$store.dispatch('position/getAll', {
    //         company_id: this.company_id
    //       });
    //     }
    //   }).finally(() => {
    //     this.btnLoader = false
    //   }).catch(err => {
    //     let error = err.response.data.data
    //     if (error) {
    //       this.showErrorField(error)
    //     } else {
    //       this.$notify.error({
    //         title: 'Error',
    //         message: err.response.data.message
    //       })
    //     }
    //   })
    // },
    // deletePosition(id) {
    //   this.$swal({
    //     title: 'HEY WAIT!, HEY HOLD ON!',
    //     text: "Are you serious to delete this cutie data ?",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes Yes Yes',
    //     cancelButtonText: 'Yes but actually NO!'
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       this.$axios.delete(`/position/${id}`).then(resp => {
    //         if (resp.data.success) {
    //           this.$notify.success({
    //             title: 'Success',
    //             message: 'Berhasil Menghapus Data'
    //           })
    //           this.shiftDialog = false
    //           this.$store.dispatch('position/getAll', {
    //             defaultPage: true,
    //             company_id: this.company_id
    //           });
    //         }
    //       }).finally(() => {
    //         //
    //       }).catch(err => {
    //         this.$notify.error({
    //           title: 'Error',
    //           message: err.response.data.message
    //         })
    //       })
    //     }
    //   })
    // },
    // formatTime(time){
    //   return moment(time, "HH:mm:ss").format('HH:mm');
    // }
  },
  computed: {
    ...mapGetters("shiftemployee", ["getSE", "getLoader"]),
  },
  watch: {

  },
};
</script>

<style lang="scss" scoped>
.heading {
  color: white;
  font-size: 25px;
  font-weight: bold;
}
</style>
