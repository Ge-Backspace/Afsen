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
        <div class="col-xl-6"></div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <vs-button
            warn
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="downloadFile(`/lapor/download/pdf`)"
            >Download PDF</vs-button
          >
          &nbsp;
          <vs-button
            success
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="downloadFile(`/lapor/download/xlsx`)"
            >Download Excel</vs-button
          >
        </div>
      </div>
      <el-card v-loading="getLoader">
        <div class="row" style="margin-bottom: 20px">
          <div class="col-md-4">
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
              <vs-th>Name</vs-th>
              <vs-th>Username</vs-th>
              <vs-th>Email</vs-th>
              <vs-th>Status Employee</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getUsers.data.data" :data="tr">
              <vs-td>
                {{ i+1 }}
              </vs-td>
              <vs-td>
                <!-- <el-link
                  ><a class="text-primary" @click="detailLaporan(tr)">{{
                    tr.judul
                  }}</a></el-link> -->
                {{ tr.name }}
              </vs-td>
              <vs-td>
                {{ tr.username }}
              </vs-td>
              <vs-td>
                {{ tr.email }}
              </vs-td>

              <vs-td>
                <span class="badge badge-success" v-if="tr.aktif">Aktif</span>
                <span class="badge badge-warning" v-else>Non Aktif</span>
              </vs-td>
              <vs-td>
                <!-- <el-tooltip
                  content="Download Evidence"
                  placement="top-start"
                  effect="dark"
                >
                  <el-button
                    size="mini"
                    @click="
                      downloadFile(`lapor/${tr.id}/evidence/download`, true)
                    "
                    icon="fa fa-download"
                  ></el-button>
                </el-tooltip> -->

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
                    @click="deleteUser(tr.id)"
                    icon="fa fa-trash"
                  ></el-button>
                </el-tooltip>
              </vs-td>
            </vs-tr>
          </template>
          <!-- <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{ getLapors.total }} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination
                  v-model="page"
                  :length="Math.ceil(getLapors.total / table.max)"
                />
              </vs-col>
            </vs-row>
          </template> -->
        </vs-table>
      </el-card>
    </div>

    <!-- Floating Button -->
    <!-- <el-tooltip
      class="item"
      effect="dark"
      content="Buat Laporan Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          tambahDialog = true;
          titleDialog = 'Tambah Karyawan';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip> -->
    <!-- End floating button-->

    <!-- <vs-dialog
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
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Fullname</label>
            <vs-input
              type="text"
              v-model="form.judul"
              placeholder="Judul"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>NIP</label>
            <vs-input
              type="text"
              v-model="form.judul"
              placeholder="Judul"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Organization</label>
            <vs-input
              type="text"
              v-model="form.tempat_kegiatan"
              placeholder="Tempat Kegiatan"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Job Position</label>
            <vs-select
              filter
              placeholder="Pelaksana Kegiatan"
              v-model="form.pelaksana_kegiatan"
            >
              <vs-option :label="test" :value="test"> </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Status Employee</label>
            <vs-select
              filter
              placeholder="Sumber Pembiayaan"
              v-model="form.sumber_pembiayaan"
            >
              <vs-option :label="status" :value="status"> </vs-option>
            </vs-select>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Email</label>
            <vs-input
              type="text"
              v-model="form.tempat_kegiatan"
              placeholder="Tempat Kegiatan"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Unit Kerja</label>
            <vs-input
              type="text"
              v-model="form.tempat_kegiatan"
              placeholder="Tempat Kegiatan"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Phone Number</label>
            <vs-input
              type="text"
              v-model="form.judul"
              placeholder="Judul"
            ></vs-input>
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
    </vs-dialog> -->

    <vs-dialog
      v-model="userDialog"
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
            <label>Name</label>
            <vs-input
              type="text"
              v-model="form.name"
              placeholder="Name"
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
              placeholder="Username"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Email</label>
            <vs-input
              disabled
              type="text"
              v-model="form.email"
              placeholder="Email"
            ></vs-input>
          </vs-col>
          <!-- <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Password</label>
            <vs-input
              type="text"
              v-model="form.password"
              placeholder="Password"
            ></vs-input>
          </vs-col> -->
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
                  userDialog = false;
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
      table: {
        max: 10,
      },
      page: 1,
      customToolbar: [
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
        [
          { align: "" },
          { align: "center" },
          { align: "right" },
          { align: "justify" },
        ],
      ],
      current_page: 1,
      titleDialog: "Tambah Laporan",
      userDialog: false,
      search: "",
      isUpdate: false,
      btnLoader: false,
      form: {
        name: "",
        username: "",
        email: "",
        // password: "",
        // tgl_selesai: "",
        // pelaksana_kegiatan: "",
        // tautan: "",
        // kategori_kegiatan: "",
        // sumber_pembiayaan: "",
        // segmen_kegiatan: "",
        // tempat_kegiatan: "",
        // aktif: true,
        // kandungan_pancasila: "",
      },
      searchDate: ["", ""],
      searchGoverment: "",
    };
  },
  mounted() {
    this.$store.dispatch("user/getAll", { showall: 1 });
  },
  methods: {
    // searchData() {
    //   let start_date = "";
    //   let end_date = "";
    //   if (this.searchDate) {
    //     start_date = this.searchDate[0];
    //     end_date = this.searchDate[1];
    //   }
    //   this.$store.dispatch("lapor/getAll", {
    //     search: this.search,
    //     start_date: start_date,
    //     end_date: end_date,
    //     goverment: this.searchGoverment,
    //   });
    // },
    // detailLaporan(data) {
    //   this.$store.commit("lapor/setLaporan", data);
    //   this.$router.push("/admin/lapor/detail");
    // },
    edit(data) {
      let form = JSON.parse(JSON.stringify(data));
      this.userDialog = true;
      this.titleDialog = "Edit User";
      this.isUpdate = true;

      // form.tgl_mulai = this.$moment(
      //   form.tgl_mulai,
      //   "DD-MM-YYYY hh:mm:ss"
      // ).format("YYYY-MM-DD");
      // form.tgl_selesai = this.$moment(
      //   form.tgl_selesai,
      //   "DD-MM-YYYY hh:mm:ss"
      // ).format("YYYY-MM-DD");
      // form.kandungan_pancasila = form.kandungan_pancasila.split(',')
      this.form = form;
    },
    resetForm() {
      this.form = {
        name: "",
        username: "",
        email: "",
        // password: "",
      };
    },
    // handleCurrentChange(val) {
    //   this.page = val;
    // },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let url = "/user/store";
      if (type == "update") {
        url = `/user/${this.form.id}/update`;
      }
      // let pancasila = "";
      // if (Array.isArray(this.form.kandungan_pancasila)) {
      //   this.form.kandungan_pancasila.forEach((e) => {
      //     if (e !== "") {
      //       pancasila += pancasila == "" ? e : "," + e;
      //     }
      //   });
      // }
      // this.form.kandungan_pancasila =
      //   pancasila !== "" ? pancasila : this.form.kandungan_pancasila;
      this.$axios
        .post(url, this.form)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Data`,
            });
            this.userDialog = false;
            this.resetForm();
            this.$store.dispatch("user/getAll", {});
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
    deleteUser(id) {
      this.$swal({
        title: "Attention!",
        text: "Are u sure u want to delete this User ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Yes Yes",
        cancelButtonText: "No No No",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/user/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "User Deleted",
                });
                this.userDialog = false;
                this.$store.dispatch("user/getAll", {
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
    ...mapGetters("user", ["getUsers"]),
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
