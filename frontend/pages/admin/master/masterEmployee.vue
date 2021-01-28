<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Data Employees</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-6">
          <el-card style="margin-top: 20px">
            <div class="row">
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="
                    tambahDialog = true;
                    titleDialog = 'Add Employee';
                    active = 6;
                  "
                >
                  <i class="bx bxs-purchase-tag"></i> Add Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="
                    active = 6;
                    importDialog = true;
                    titleDialog = 'Bulk Add Employees';
                  "
                >
                  <i class="bx bxs-purchase-tag"></i> Bulk Add Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> History
                </vs-button>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader" style="margin-top: 80px">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-3 offset-md-9">
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
                  <vs-th>No</vs-th>
                  <vs-th>Fullname</vs-th>
                  <vs-th>Nip</vs-th>
                  <vs-th>Position</vs-th>
                  <vs-th>Group</vs-th>
                  <vs-th>Kontak</vs-th>
                  <vs-th>Status Employee</vs-th>
                  <vs-th>Username</vs-th>
                  <vs-th>Admin</vs-th>
                  <vs-th>Status User</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getEmployees.data" :data="tr">
                  <vs-td>
                    {{ i + 1 }}
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.nip }}
                  </vs-td>
                  <vs-td>
                    {{ tr.position_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.group }}
                  </vs-td>
                  <vs-td>
                    {{ tr.kontak }}
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.status"
                      >Aktif</span
                    >
                    <span class="badge badge-warning" v-else>Non Aktif</span>
                  </vs-td>
                  <vs-td>
                    {{ tr.username }}
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.admin"
                      >Aktif</span
                    >
                    <span class="badge badge-warning" v-else>Non Aktif</span>
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.aktif"
                      >Aktif</span
                    >
                    <span class="badge badge-warning" v-else>Non Aktif</span>
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
                        @click="deleteCompany(tr.id)"
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
                    <small>Total : {{ getEmployees.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getEmployees.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Laporan Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          request = true;
          tambahDialog = true;
          titleDialog = 'Add Employee';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button-->

    <vs-dialog
      v-model="tambahDialog"
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
            v-if="this.request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Nama</label>
            <vs-input
              type="text"
              v-model="form.name"
              placeholder="Nama"
            ></vs-input>
          </vs-col>
          <vs-col
            v-if="this.request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Email</label>
            <vs-input
              type="text"
              v-model="form.email"
              placeholder="Nama"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Nip</label>
            <vs-input
              type="number"
              v-model="form.nip"
              placeholder="Address"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Position</label>
            <vs-select
              filter
              placeholder="Positions"
              v-model="form.position_id"
            >
              <vs-option
                v-for="op in option"
                :key="op.id"
                :label="op.position_name"
                :value="op.id"
              >
                {{ op.position_name }}
              </vs-option>
            </vs-select>
          </vs-col>
          <!-- <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Group</label>
            <vs-select filter placeholder="Group" v-model="form.position_name">
              <vs-option v-for="op in option" :key="op.id" :label="op.position_name" :value="op.id">
                {{op.position_name}}
              </vs-option>
            </vs-select>
          </vs-col> -->
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Kontak</label>
            <vs-input
              type="number"
              v-model="form.kontak"
              placeholder="Address"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Username</label>
            <vs-input
              type="text"
              v-model="form.username"
              placeholder="Address"
            ></vs-input>
          </vs-col>
          <vs-col
            v-if="this.request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Password</label>
            <vs-input
              type="password"
              v-model="form.password"
              placeholder="Nama"
            ></vs-input>
          </vs-col>
          <!-- <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Status</label>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.status" />
            </vs-col>
          </vs-col> -->
          <vs-row>
            <vs-col w="2">
              <label>Status Employee</label>
            </vs-col>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.status" />
            </vs-col>
            <vs-col w="2">
              <label>Admin</label>
            </vs-col>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.admin" />
            </vs-col>
            <vs-col w="2">
              <label>Status User</label>
            </vs-col>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.aktif" />
            </vs-col>
          </vs-row>
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
                  tambahDialog = false;
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
          <vs-input<input type="file" id="file" ref="file" />
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

export default {
  layout: "admin",
  data() {
    return {
      data: {},
      company_id: "",
      table: {
        max: 10,
      },
      
      request: false,
      active: "",
      option: [],
      page: 1,
      current_page: 1,
      titleDialog: "Tambah Karyawan",
      tambahDialog: false,
      importDialog: false,
      search: "",
      company_id: JSON.parse(JSON.stringify(this.$auth.user.company_id)),
      isUpdate: false,
      btnLoader: false,
      form: {
        name: "",
        email: "",
        nip: "",
        position_id: "",
        group: "",
        kontak: "",
        status: "",
        username: "",
        password: "",
        admin: "",
        aktif: ""
      },
      // active: "",
      // searchDate: ["", ""],
      // searchGoverment: "",
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("employee/getAll", { company_id: this.company_id });
    this.$axios
      .get(`/employees?company_id=${this.company_id}`)
      .then((resp) => {});
    this.$axios
      .get(`/optionPosition?company_id=${this.company_id}`)
      .then((resp) => {
        this.option = resp.data.data;
      });
  },
  methods: {
    searchData() {
      this.$store.dispatch("employee/getAll", {
        search: this.search,
      });
    },
    edit(data) {
      this.form.id = data.id;
      this.form.nip = data.nip;
      this.form.position_id = data.position_id;
      this.form.kontak = data.kontak;
      this.form.status = data.status;
      this.form.admin = data.admin;
      this.form.aktif = data.aktif;
      this.tambahDialog = true;
      this.titleDialog = "Edit Employee";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        name: "",
        email: "",
        position_id: "",
        kontak: "",
        status: "",
        username: "",
        admin: "",
        aktif: ""
      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("employee/setPage", val);
      this.$store.dispatch("employee/getAll", {});
    },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("name", this.form.name);
      formData.append("email", this.form.email);
      formData.append("nip", this.form.nip);
      formData.append("position_id", this.form.position_id);
      formData.append("kontak", this.form.kontak);
      formData.append("status", this.form.status ? 1 : 0);
      formData.append("password", this.form.passowrd);
      formData.append("username", this.form.username);
      formData.append("admin", this.form.admin ? 1 : 0);
      formData.append("aktif", this.form.aktif ? 1 : 0);
      let url = "/employee";
      if (type == "update") {
        url = `/employee/update/${this.form.id}`;
      }
      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Company`,
            });
            this.resetForm();
            this.tambahDialog = false;
            this.$store.dispatch("employee/getAll", {
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
    deleteCompany(id) {
      this.$swal({
        title: "Perhatian!",
        text: "Apakah anda yakin ingin menghapus data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/employee/delete/${id}`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.tambahDialog = false;
                this.$store.dispatch("employee/getAll", {
                  defaultPage: true,
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
  },
  computed: {
    // ...mapGetters("lapor", ["getLapors", "getLoader"]),
    // ...mapGetters("setting", ["getSetting"]),
    // ...mapGetters("goverment", ["getGovermentPlains"]),
    ...mapGetters("employee", [
      "getEmployees",
      // "getLoader"
    ]),
    ...mapGetters("option", ["getOption"]),
    ...mapGetters("position", ["getPosition"]),
  },
  watch: {
    // getLapors(newValue, oldValue) {},
    // getSetting(newValue, oldValue) {
    //   console.log(newValue);
    // },
    // search(newValue, oldValue) {
    //   // this.$store.dispatch('lapor/getAll', {
    //   //   search: newValue
    //   // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit("lapor/setPage", newValue);
    //   this.$store.dispatch("lapor/getAll", {});
    // },
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
