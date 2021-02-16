<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Permission Cuti</h1>
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
          <br />

          <el-card v-loading="getLoader" style="margin-top: 100px">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-2">
                <vs-button
                  success
                  style="float: right"
                  :loading="globalLoader"
                  gradient
                  @click="
                    importDialog = true;
                    titleDialog = 'Import Shift Employee';
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
                  <vs-th>Status</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getCutiPs.data" :data="tr">
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
                    <span class="badge badge-primary" v-if="tr.status_id == 0"
                      >Waiting</span
                    >
                    <span
                      class="badge badge-success"
                      v-else-if="tr.status_id == 1"
                      >Accepted</span
                    >
                    <span class="badge badge-warning" v-else>Rejected</span>
                  </vs-td>
                  <vs-td>
                    <el-tooltip
                      content="Edit"
                      placement="top-start"
                      effect="dark"
                    >
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
                        @click="deleteCutiE(tr.id)"
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
                  <template #expand>
                    <div class="con-content">

                        <h3>Reason</h3>
                        <div v-html="tr.reason">
                        {{ tr.reason }}
                      </div>
                    </div>
                  </template>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getCutiPs.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getCutiPs.total / table.max)"
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
      content="Buat Cuti Permission Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          seDialog = true;
          titleDialog = 'Permohonan Izin Cuti';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog
      v-model="seDialog"
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
            <vs-select
              filter
              placeholder="Employee Name"
              v-model="form.employee_id"
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
            <label>Cuti Name</label>
            <vs-select filter placeholder="Type" v-model="form.cuti_id">
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
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Reason</label>
            <client-only>
              <vue-editor v-model="form.reason"></vue-editor>
            </client-only>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Upload Document</label>
            <el-upload
              :action="api_url + '/fake-upload'" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
            :file-list="files" :limit="1"
            >
              <i class="el-icon-plus"></i>
            </el-upload>
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
      titleDialog: "Edit Shift Employee",
      search: "",
      company_id: "",
      isUpdate: false,
      seDialog: false,
      btnLoader: false,
      files: "",
      form: {
        id: "",
        employee_id: "",
        cuti_id: "",
        start_date: "",
        expired_date: "",
        reason: "",
      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("cutipermission/getAll", {
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
    searchData() {
      this.$store.dispatch("cutipermission/getAll", {
        search: this.search,
        company_id: this.company_id,
      });
    },
    edit(data) {
      this.form.id = data.id;
      this.form.employee_id = data.employee_id;
      this.form.cuti_id = data.cuti_id;
      this.form.start_date = data.start_date;
      this.form.expired_date = data.expired_date;
      this.form.reason = data.reason;
      this.file = data.file;
      this.seDialog = true;
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
      this.$store.commit("cutipermission/setPage", val);
      this.$store.dispatch("cutipermission/getAll", {
        company_id: this.company_id,
      });
    },
    handleChangeFile(file, fileList) {
      console.log(file);
      this.form.files = file.raw;
    },
    handleChangeSelect(data) {
      this.$store.dispatch("cutipermission/getAll", {
        company_id: this.company_id,
        showall: 0,
      });
    },
    importData() {
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("file", this.file);
      this.$axios
        .post("/cutipermission/import", formData, {
          headers: { "content-type": "multipart/form-data" },
        })
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: "Berhasil Import Shift Employee",
            });
            this.resetForm();
            this.importDialog = false;
            this.$store.dispatch("cutipermission/getAll", {
              company_id: this.company_id,
            });
          }
        })
        .catch((error) => {
          this.uploading = false;
          this.error = error.resp.data;
          console.log("check error: ", this.error);
        })
        .finally(() => {
          this.btnLoader = false;
        });
    },
    exportData(type = "excel") {
      this.$axios
        .get(
          `/cutipermission/export?company_id=${this.company_id}&as=${type}`,
          {
            responseType: "blob",
          }
        )
        .then((response) => {
          const link = document.createElement("a");
          link.href = window.URL.createObjectURL(new Blob([response.data]));
          if (type == "pdf") {
            link.setAttribute("download", "cuti_permission.pdf");
          } else {
            link.setAttribute("download", "cuti_permission.xlsx");
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
      formData.append("reason", this.form.reason);
      // formData.append("file", this.file);
      if (this.form.files) {
          formData.append("foto", this.form.files)
        }
      let url = "/cutipermission";
      if (type == "update") {
        url = `cutipermission/${this.form.id}/update`;
      }

      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Shift Employee`,
            });
            this.resetForm();
            this.seDialog = false;
            this.$store.dispatch("cutipermission/getAll", {
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
    deleteCutiE(id) {
      this.$swal({
        title: "HEY WAIT!, HEY HOLD ON!",
        text: "Are you serious to delete this data ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Yes Yes",
        cancelButtonText: "Yes but actually NO!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/cutipermission/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.shiftDialog = false;
                this.$store.dispatch("cutipermission/getAll", {
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
    status(id) {
      this.$swal({
        title: "Cormfirmation",
        text: "Accept or Reject this Permission",
        icon: "warning",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: "#3085d6",
        denyButtonColor: "#d33",
        confirmButtonText: "Accept",
        denyButtonText: "Reject",
        cancelButtonText: "Cancel",
      }).then((result) => {
        let status = 0;
        if (result.isConfirmed) {
          status = 1;
        } else if (result.isDenied) {
          status = 2;
        }
        if (status != 0) {
          this.change(id, status);
        }
      });
    },
    change(id, status) {
      this.$axios
        .post(`/cutipermission/${id}/change?status=${status}`)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                status == 1 ? "Accept" : "Reject"
              } Permission`,
            });
          }
        })
        .catch((err) => {
          this.$notify.error({
            title: "Error",
            message: err.response.data.message,
          });
        })
        .finally(() => {
          this.$store.dispatch("cutipermission/getAll", {
            company_id: this.company_id,
          });
        });
    },
    formatDate(date) {
      return moment(date).format("DD MMMM YYYY");
    },
  },
  computed: {
    ...mapGetters("cutipermission", ["getCutiPs", "getLoader"]),
    ...mapGetters("option", ["getOptionEmployees", "getOptionCuties"]),
  },
  watch: {
    getCutiPs(newValue, oldValue) {
      //
    },
    search(newValue, oldValue) {
      this.$store.dispatch("shiftemployee/getAll", {
        search: newValue,
      });
    },
    page(newValue, oldValue) {
      this.$store.commit("cutipermission/setPage", newValue);
      this.$store.dispatch("cutipermission/getAll", {
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
