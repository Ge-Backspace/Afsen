<template>
  <div>
    <div class="header bg-primary pb-6" >
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
          <vs-button
            warn
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="exportData('pdf')"
            >Download PDF</vs-button
          >
          &nbsp;
          <vs-button
            success
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="exportData('excel')"
            >Download Excel</vs-button
          >
        
      <el-card v-loading="getLoader" style="margin-top: 40px">
        <div class="row" style="margin-bottom: 20px">
          <div class="col-md-2">
            <vs-button
              success
              style="float: right"
              :loading="globalLoader"
              gradient
              @click="
              importDialog = true
              titleDialog = 'Import Shift Employee'
              "
              >Import Excel</vs-button
            >
          </div>
          <div class="col-md-3 offset-md-7">
            <el-input
              placeholder="Cari"
              v-model="search"
              @change="searchData()"
              size="mini"
            >
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
          </div>
        </div>
        <vs-table striped>
          <template #thead>
            <vs-tr>
              <vs-th>Pengaju</vs-th>
              <vs-th>Pengganti</vs-th>
              <vs-th>Shift Pengaju</vs-th>
              <vs-th>Shift Pengganti</vs-th>
              <vs-th>Status</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getShiftPs.data" :data="tr">
              <vs-td>
                {{ tr.name1 }}
              </vs-td>
              <vs-td>
                {{ tr.name2 }}
              </vs-td>
              <vs-td>
                {{ formatDate(tr.date1) }} {{ tr.code1 }} ({{ tr.schedule_in1 }} - {{ tr.schedule_out1 }})
              </vs-td>
              <vs-td>
                {{ formatDate(tr.date2) }} {{ tr.code2 }} ({{ tr.schedule_in2 }} - {{ tr.schedule_out2 }})
              </vs-td>
              <vs-td>
                <span class="badge badge-primary" v-if="tr.status_id == 0">Waiting</span>
                <span class="badge badge-success" v-else-if="tr.status_id == 1">Accepted</span>
                <span class="badge badge-warning" v-else>Rejected</span>
              </vs-td>
              <vs-td>
                <el-tooltip content="Edit" placement="top-start" effect="dark">
                  <el-button
                    size="mini"
                    @click="edit(tr)"
                    icon="fa fa-edit"
                  ></el-button>
                </el-tooltip>

                <el-tooltip
                  content="Delete"
                  placement="top-start"
                  effect="dark"
                >
                  <el-button
                    size="mini"
                    type="primary"
                    @click="deleteShift(tr.id)"
                    icon="fa fa-trash"
                  >
                  </el-button>
                </el-tooltip>
                <el-tooltip
                v-if="tr.status_id == 0"
                  content="Change Status"
                  placement="top-start"
                  effect="dark"
                >
                  <el-button
                    size="mini"
                    type="warning"
                    @click="status(tr.id)"
                    icon="el-icon-refresh"
                  >
                  </el-button>
                </el-tooltip>
                <el-tooltip
                  v-else
                  content="Change Status"
                  placement="top-start"
                  effect="dark"
                >
                  <el-button
                    disabled
                    size="mini"
                    type="warning"
                    icon="el-icon-refresh"
                  >
                  </el-button>
                </el-tooltip>
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{ getShiftPs.total }} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination
                  v-model="page" :length="Math.ceil(getShiftPs.total / table.max)"
                />
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </el-card>
    </div>
    </div>
      </div>
    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Shift Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          seDialog = true;
          titleDialog = 'Pengajuan Pergantian Cuti';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog
      v-model="seDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm(),
      optionshift1 = false,
      optionshift2 = false
      "
    >
      <template #header>
        <h1 class="not-margin">
          {{ titleDialog }}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Employee pengaju</label>
            <vs-select
              filter
              placeholder="Employee"
              v-model="form.employee1_id"
              @change="
              getshift1(form.employee1_id)
              optionshift1 = true
              "
            >
              <vs-option
                v-for="op in getOptionEmployees.data"
                :key="op.id"
                :label="op.name"
                :value="op.id"
              >
                {{ op.name }}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Employee Pengganti</label>
            <vs-select
              filter
              placeholder="Employee"
              v-model="form.employee2_id"
              @change="
              getshift2(form.employee2_id)
              optionshift2 = true
              "
            >
              <vs-option
                v-for="op in getOptionEmployees.data"
                :key="op.id"
                :label="op.name"
                :value="op.id"
              >
                {{ op.name }}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            v-loading="getLoader"
            v-if="optionshift1"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Shift Pengaju</label>
            <vs-select
              filter
              placeholder="Shift"
              v-model="form.shift_employee1_id"
            >
              <vs-option
                v-for="op in getOptionShiftE1.data"
                :key="op.id"
                :label="[[formatDate(op.date), op.code, op.schedule_in, op.schedule_out]]"
                :value="op.id"
              >
                {{ formatDate(op.date) }} ({{ op.code }})
                ,{{ op.schedule_in }}-{{ op. schedule_out }}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            v-loading="getLoader"
            v-if="optionshift2"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Shift Pengganti</label>
            <vs-select
              filter
              placeholder="Shift"
              v-model="form.shift_employee2_id"
            >
              <vs-option
                v-for="op in getOptionShiftE2.data"
                :key="op.id"
                :label="[[formatDate(op.date), op.code, op.schedule_in, op.schedule_out]]"
                :value="op.id"
              >
                {{ formatDate(op.date) }} ({{ op.code }})
                ,{{ op.schedule_in }}-{{ op. schedule_out }}
              </vs-option>
            </vs-select>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('update')"
                v-if="isUpdate"
                >Update</vs-button
              >
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('store')"
                v-else
                >Simpan</vs-button
              >
            </vs-col>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                border
                @click="
                  seDialog = false;
                  resetForm();
                "
                >Batal</vs-button
              >
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
    <vs-dialog
      v-model="importDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()"
    >
      <template #header>
        <h1 class="not-margin">
          {{ titleDialog }}
        </h1>
      </template>
      <div class="con-form">
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="6"
          style="padding: 5px"
        >
          <label>Import Employee</label>
          <vs-input<input type="file" id="file" ref="file" @change="onFileChange"/>
        </vs-col>
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="6"
          style="padding: 5px"
        >
          <vs-button
            color="primary"
            gradient
            :active="active == 6"
            @click="active = 6"
          >
            <i class="bx bx-file-blank"></i> download templates
          </vs-button>
        </vs-col>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                :loading="btnLoader"
                @click="importData()"
                >Simpan</vs-button
              >
            </vs-col>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                border
                @click="
                  importDialog = false;
                  resetForm();
                "
                >Batal</vs-button
              >
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
      optionshift1: false,
      optionshift2: false,
      request: false,
      importDialog: false,
      active: 0,
      page: 1,
      titleDialog: "Edit Permission Shift",
      search: '',
      company_id: '',
      isUpdate: false,
      seDialog: false,
      btnLoader: false,
      file: '',
      form: {
        id:'',
        employee1_id: '',
        employee2_id: '',
        shift_employee1_id: '',
        shift_employee2_id: '',
      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch('shiftpermission/getAll', {
      company_id: this.company_id,
    });
    this.$store.dispatch('option/getOptionEmployees', {
      company_id: this.company_id
    })
    this.$store.dispatch('option/getOptionShiftEmployee', {
      employee_id: 0
    })
    
  },
  methods: {
    searchData(){
      this.$store.dispatch('shiftemployee/getAll', {
        search: this.search,
        company_id: this.company_id
      });
    },
    edit(data) {
      this.form.id = data.id;
      this.employee1_id = data.employee1_id;
      this.employee2_id = data.employee2_id;
      this.shift_employee1_id = data.shift_employee1_id;
      this.shift_employee2_id = data.shift_employee2_id;
      this.seDialog = true;
      this.titleDialog = "Edit";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        id: '',
        employee1_id: '',
        employee2_id: '',
        shift_employee1_id: '',
        shift_employee2_id: '',
      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit('shiftemployee/setPage', val)
      this.$store.dispatch('shiftemployee/getAll', {
        company_id: this.company_id
      });
    },
    onFileChange(e){
      this.file = e.target.files[0];
    },
    importData(){
      let formData = new FormData();
      formData.append('company_id', this.company_id);
      formData.append('file', this.file);
      this.$axios.post('/shiftpermission/import', formData, {
        headers: {'content-type': 'multipart/form-data' }
      })
      .then(resp => {
        if(resp.data.success){
          this.$notify.success({
            title: 'Success',
            message: 'Berhasil Import Shift Employee'
          })
          this.resetForm()
          this.importDialog = false
          this.$store.dispatch('shiftpermission/getAll', {
            company_id: this.company_id
          });
        }
      })
      .catch(error => {
        this.uploading = false
        this.error = error.resp.data
        console.log('check error: ', this.error)
      })
      .finally(() => {
        this.btnLoader = false
      })
    },
    exportData(type){
        this.$axios.get(`/shiftpermission/export?company_id=${this.company_id}&as=${type}`, {
          responseType: 'blob'
        }).then((response) => {
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(
            new Blob([response.data])
          );
          if (type == 'pdf') {
            link.setAttribute('download','shift_permission.pdf');
          } else {
            link.setAttribute('download','shift_permission.xlsx');
          }
          document.body.appendChild(link);
          link.click();
        });
      },
    onSubmit(type = 'store') {
      this.btnLoader = true
      let formData = new FormData()
      formData.append('company_id', this.company_id)
      formData.append('employee1_id', this.form.employee1_id)
      formData.append('employee2_id', this.form.employee2_id)
      formData.append('shift_employee1_id', this.form.shift_employee1_id)
      formData.append('shift_employee2_id', this.form.shift_employee2_id)
      let url = '/shiftpermission'
      if (type == 'update') {
        url = `shiftpermission/${this.form.id}/update`
      }

      this.$axios.post(url, formData).then(resp => {
        if (resp.data.success) {
          this.$notify.success({
            title: 'Success',
            message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Shift Employee`
          })
          this.resetForm()
          this.seDialog = false
          this.$store.dispatch('shiftpermission/getAll', {
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
    deleteShift(id) {
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
          this.$axios.delete(`/shiftpermission/${id}/delete`).then(resp => {
            if (resp.data.success) {
              this.$notify.success({
                title: 'Success',
                message: 'Berhasil Menghapus Data'
              })
              this.shiftDialog = false
              this.$store.dispatch('shiftpermission/getAll', {
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
    getshift1(id) {
      this.$store.dispatch('option/getOptionShiftEmployee1', {
        employee_id: id
      })
    },
    getshift2(id) {
      this.$store.dispatch('option/getOptionShiftEmployee2', {
        employee_id: id
      })
    },
    status(id) {
      this.$swal({
        title: 'Cormfirmation',
        text: 'Accept or Reject this Permission',
        icon: "warning",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: "#3085d6",
        denyButtonColor: "#d33",
        confirmButtonText: "Accept",
        denyButtonText: "Reject",
        cancelButtonText: "Cancel",
      }).then((result) => {
        let status = 0
        if (result.isConfirmed) {
          status = 1
        } else if (result.isDenied) {
          status = 2
        }
        if (status != 0) {
          this.change(id, status)
        }
      })
    },
    change(id, status) {
      this.$axios.post(`/shiftpermission/${id}/change?status=${status}`)
      .then(resp => {
        if (resp.data.success) {
          this.$notify.success({
            title: "Success",
            message: `Berhasil ${status == 1 ? "Accept" : "Reject"} Permission`,
          });
        }
      }).catch((err) => {
        this.$notify.error({
          title: "Error",
          message: err.response.data.message,
        });
      }).finally(() => {
        this.$store.dispatch('shiftpermission/getAll', {
          company_id: this.company_id,
        });
      })
    },
    formatDate(date){
      return moment(date).format('DD MMMM YYYY');
    }
  },
  computed: {
    ...mapGetters('shiftpermission', ['getShiftPs', 'getLoader']),
    ...mapGetters('option', ['getOptionShifts', 'getOptionEmployees', 'getOptionShiftE1', 'getOptionShiftE2' ]),
  },
  watch: {
    getShiftPs(newValue, oldValue) {
      //
    },
    search(newValue, oldValue) {
      this.$store.dispatch('shiftpermission/getAll', {
        search: newValue
      });
    },
    page(newValue, oldValue) {
      this.$store.commit('shiftpermission/setPage', newValue)
      this.$store.dispatch('shiftpermission/getAll', {
        company_id: this.company_id
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.heading {
  color: white;
  font-size: 25px;
  font-weight: bold;
}
</style>
