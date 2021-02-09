<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Cuti Employee</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
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
                importDialog = true;
                titleDialog = 'Import Cuti Employee';
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
              <vs-th>Employee</vs-th>
              <vs-th>Nama Cuti</vs-th>
              <vs-th>Code Cuti</vs-th>
              <vs-th>Start Date</vs-th>
              <vs-th>Expired Date</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getCutiEs.data" :data="tr">
              <vs-td>
                {{ tr.name }}
              </vs-td>
              <vs-td>
                {{ tr.cuti_name }}
              </vs-td>
              <vs-td>
                {{ tr.code }}
              </vs-td>
              <vs-td>
                {{ formatDate(tr.start_date) }}
              </vs-td>
              <vs-td>
                {{ formatDate(tr.expired_date) }}
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
                    @click="deleteCuties(tr.id)"
                    icon="fa fa-trash"
                  >
                  </el-button>

                </el-tooltip>

              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{ getCutiEs.total }} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination
                  v-model="page"
                  :length="Math.ceil(getCutiEs.total / table.max)"
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
      content="Buat Cuti Employee Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          toDialog = true;
          titleDialog = 'Tambah Employee Cuti Employee';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog
      v-model="toDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()"
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
            <label>Employee</label>
            <vs-select filter placeholder="Employee" v-model="form.employee_id">
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
            <label>Cuti Name</label>
            <vs-select filter placeholder="Cuti Employee" v-model="form.cuti_id">
              <vs-option
                v-for="op in getOptionCuties.data"
                :key="op.id"
                :label="[op.code, op.cuti_name]"
                :value="op.id"
              >
                {{ op.cuti_name }},{{ op.code }}
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
            <label>Start Date</label>
            <vs-input type="date" v-model="form.start_date"></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Expired Date</label>
            <vs-input type="date" v-model="form.expired_date"></vs-input>
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
                  toDialog = false;
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
          <vs-input<input
            type="file"
            id="file"
            ref="file"
            @change="onFileChange"
          />
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
              <vs-button block :loading="btnLoader" @click="importData()"
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
      request: false,
      importDialog: false,
      active: 0,
      page: 1,
      titleDialog: "Edit Time Off Employee",
      search: "",
      company_id: "",
      isUpdate: false,
      toDialog: false,
      btnLoader: false,
      file: "",
      form: {
        id: "",
        employee_id: "",
        cuti_id: "",
        start_date: "",
        expired_date: "",
      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("cutiemployee/getAll", {
      company_id: this.company_id,
    });
    this.$store.dispatch("option/getOptionEmployees", {
      company_id: this.company_id,
    });
    this.$store.dispatch("option/getOptionCuties", {
      company_id: this.company_id,
    });
  },
  methods: {
    searchData(){
      this.$store.dispatch('cutiemployee/getAll', {
        search: this.search,
        company_id: this.company_id
      });
    },
    edit(data) {
      this.form.id = data.id;
      console.log(this.form.id);
      this.form.employee_id = data.employee_id;
      this.form.cuti_id = data.cuti_id;
      this.form.start_date = data.start_date;
      this.form.expired_date = data.expired_date;
      this.toDialog = true;
      this.titleDialog = "Edit";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        id: "",
        employee_id: "",
        cuti_id: "",
        start_date: "",
        expired_date: "",
      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("cutiemployee/setPage", val);
      this.$store.dispatch("cutiemployee/getAll", {
        company_id: this.company_id,
      });
    },
    onFileChange(e) {
      this.file = e.target.files[0];
    },
    importData(){
      let formData = new FormData();
      formData.append('company_id', this.company_id);
      formData.append('file', this.file);
      this.$axios.post('/cutiemployee/import', formData, {
        headers: {'content-type': 'multipart/form-data' }
      })
      .then(resp => {
        if(resp.data.success){
          this.$notify.success({
            title: 'Success',
            message: 'Berhasil Import Cuti Employee'
          })
          this.resetForm()
          this.importDialog = false
          this.$store.dispatch('cutiemployee/getAll', {
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
    exportData(type = 'excel'){
        this.$axios.get(`/cutiemployee/export?company_id=${this.company_id}&as=${type}`, {
          responseType: 'blob'
        }).then((response) => {
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(
            new Blob([response.data])
          );
          if (type == 'pdf') {
            link.setAttribute('download','cuti_employee.pdf');
          } else {
            link.setAttribute('download','cuti_employee.xlsx');
          }
          document.body.appendChild(link);
          link.click();
        });
      },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("employee_id", this.form.employee_id);
      formData.append("cuti_id", this.form.cuti_id);
      formData.append("start_date", this.form.start_date);
      formData.append("expired_date", this.form.expired_date);
      let url = "/cutiemployee";
      if (type == "update") {
        url = `cutiemployee/${this.form.id}/update`;
      }

      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Cuti Employee`,
            });
            this.resetForm();
            this.toDialog = false;
            this.$store.dispatch("cutiemployee/getAll", {
              company_id: this.company_id,
            });
          }
        })
        .finally(() => {
          this.btnLoader = false;
        })
        .catch((err) => {
          let error = err.response.data.data;
          if (error) {
            this.showErrorField(error);
          } else {
            this.$notify.error({
              title: "Error",
              message: err.response.data.message,
            });
          }
        });
    },
    deleteCuties(id) {
      this.$swal({
        title: "HEY WAIT!, HEY HOLD ON!",
        text: "Are you serious to delete this cutie data ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Yes Yes",
        cancelButtonText: "Yes but actually NO!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/cutiemployee/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.toDialog = false;
                this.$store.dispatch("cutiemployee/getAll", {
                  company_id: this.company_id,
                });
              }
            })
            .finally(() => {
              //
            })
            .catch((err) => {
              this.$notify.error({
                title: "Error",
                message: err.response.data.message,
              });
            });
        }
      });
    },
    formatDate(date) {
      return moment(date).format("DD MMMM YYYY");
    },
  },
  computed: {
    ...mapGetters("cutiemployee", ["getCutiEs", "getLoader"]),
    ...mapGetters("option", ["getOptionCuties", "getOptionEmployees"]),
  },
  watch: {
    getCutiEs(newValue, oldValue) {
      //
    },
    search(newValue, oldValue) {
      this.$store.dispatch("cutiemployee/getAll", {
        search: newValue,
      });
    },
    page(newValue, oldValue) {
      this.$store.commit("cutiemployee/setPage", newValue);
      this.$store.dispatch("cutiemployee/getAll", {
        company_id: this.company_id,
      });
    },
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
