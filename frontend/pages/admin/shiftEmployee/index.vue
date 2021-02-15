<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Shift Employee</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <br />
          <el-card v-loading="getLoader">
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
                  <vs-th>Code</vs-th>
                  <vs-th>Shift</vs-th>
                  <vs-th>Schedule In</vs-th>
                  <vs-th>Schedule Out</vs-th>
                  <vs-th>Date</vs-th>
                  <vs-th>Action</vs-th>
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
                    {{ formatDate(tr.date) }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip
                      content="Edit"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        @click="edit(tr);
                        requestEdit = true"
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
          titleDialog = 'Tambah Employee Shift';
          requestAdd = true;
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog
      v-model="seDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm();
      requestAdd = false;
      requestEdit = false;"
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
            <label>Shift Name</label>
            <vs-select filter placeholder="Shift" v-model="form.shift_id">
              <vs-option
                v-for="op in getOptionShifts.data"
                :key="op.id"
                :label="[op.shift_name, op.schedule_in, op.schedule_out]"
                :value="op.id"
              >
                {{ op.shift_name }},{{ op.schedule_in }}-{{ op.schedule_out }}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            v-if="requestAdd"
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
            v-if="requestAdd"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>End Date</label>
            <vs-input type="date" v-model="form.end_date"></vs-input>
          </vs-col>
          <vs-col
          v-if="requestAdd == false"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Date</label>
            <vs-input type="date" v-model="form.date"></vs-input>
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
      importDialog: false,
      active: 0,
      page: 1,
      titleDialog: "Edit Shift Employee",
      search: "",
      requestEdit: false,
      requestAdd: false,
      company_id: "",
      isUpdate: false,
      seDialog: false,
      btnLoader: false,
      file: "",
      form: {
        id: "",
        employee_id: "",
        shift_id: "",
        start_date: "",
        end_date: ""
      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("shiftemployee/getAll", {
      company_id: this.company_id,
    });
    this.$store.dispatch("option/getOptionEmployees", {
      company_id: this.company_id,
    });
    this.$store.dispatch("option/getOptionShifts", {
      company_id: this.company_id,
    });
  },
  methods: {
    searchData() {
      this.$store.dispatch("shiftemployee/getAll", {
        search: this.search,
        company_id: this.company_id,
      });
    },
    edit(data) {
      this.form.id = data.id;
      console.log(this.form.id);
      this.form.employee_id = data.employee_id;
      console.log(this.form.employee_id);
      console.log(this.form.shift_id);
      this.form.shift_id = data.shift_id;
      this.form.start_date = data.start_date;
      this.form.end_date = data.end_date;
      this.seDialog = true;
      this.titleDialog = "Edit";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        id: "",
        employee_id: "",
        shift_id: "",
        start_date: "",
        end_date: ""
      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("shiftemployee/setPage", val);
      this.$store.dispatch("shiftemployee/getAll", {
        company_id: this.company_id,
      });
    },
    onFileChange(e) {
      this.file = e.target.files[0];
    },
    importData() {
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("file", this.file);
      this.$axios
        .post("/shiftEmployee/import", formData, {
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
            this.$store.dispatch("shiftemployee/getAll", {
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
        .get(`/shiftEmployee/export?company_id=${this.company_id}&as=${type}`, {
          responseType: "blob",
        })
        .then((response) => {
          const link = document.createElement("a");
          link.href = window.URL.createObjectURL(new Blob([response.data]));
          if (type == "pdf") {
            link.setAttribute("download", "shift.pdf");
          } else {
            link.setAttribute("download", "shift.xlsx");
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
      formData.append("shift_id", this.form.shift_id);
      formData.append("start_date", this.form.start_date);
      formData.append("end_date", this.form.end_date);
      console.log(this.form.start_date);
      console.log(this.form.end_date);
      console.log(this.form.company_id);
      console.log(this.form.employee_id);
      console.log(this.form.shift_id);
      let url = "/shiftEmployee";
      if (type == "update") {
        url = `shiftEmployee/${this.form.id}/update`;
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
            this.$store.dispatch("shiftemployee/getAll", {
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
    deleteShift(id) {
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
            .delete(`/shiftEmployee/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.shiftDialog = false;
                this.$store.dispatch("shiftemployee/getAll", {
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
    ...mapGetters("shiftemployee", ["getSE", "getLoader"]),
    ...mapGetters("option", ["getOptionShifts", "getOptionEmployees"]),
  },
  watch: {
    getSE(newValue, oldValue) {
      //
    },
    // search(newValue, oldValue) {
    //   this.$store.dispatch("shiftemployee/getAll", {
    //     search: newValue,
    //   });
    // },
    page(newValue, oldValue) {
      this.$store.commit("shiftemployee/setPage", newValue);
      this.$store.dispatch("shiftemployee/getAll", {
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
