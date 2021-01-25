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
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Add Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
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
                  <i class="bx bxs-purchase-tag"></i> Update Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Transfer History
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> PTKP Status
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Other Import
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
                  <vs-th>No</vs-th>
                  <vs-th>Fullname</vs-th>
                  <vs-th>Nip</vs-th>
                  <vs-th>Position</vs-th>
                  <vs-th>Status</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getEmployees.data" :data="tr">
                  <vs-td>
                    {{ i }}
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    {{  }}
                  </vs-td>
                  <vs-td>
                    {{  }}
                  </vs-td>
                  <vs-td>
                    {{  }}
                  </vs-td>
                  <vs-td>
                    {{  }}
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getEmployees.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getEmployees.total / table.max)" />
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
          tambahDialog = true;
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
    </vs-dialog>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

export default {
  layout: "admin",
  data() {
    return {
      data:{

      },
      company_id: '',
      table: {
        max: 10,
      },
      page: 1,
      current_page: 1,
      titleDialog: 'Tambah Karyawan',
      tambahDialog: false,
      search: "",
      isUpdate: false,
      btnLoader: false,
      form: {
        judul: "",
        deskripsi: "",
        evidences: [],
        tgl_mulai: "",
        tgl_selesai: "",
        pelaksana_kegiatan: "",
        tautan: "",
        kategori_kegiatan: "",
        sumber_pembiayaan: "",
        segmen_kegiatan: "",
        tempat_kegiatan: "",
        aktif: true,
        kandungan_pancasila: "",
      },
      active:'',
      searchDate: ["", ""],
      searchGoverment: "",
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id))
    this.$store.dispatch('employee/getAll', {company_id: this.company_id})
    this.$axios.get(`/employees?company_id=${this.company_id}`).then(resp =>{
      console.log(resp)
    })
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
    // edit(data) {
    //   let form = JSON.parse(JSON.stringify(data));
    //   this.tambahDialog = true;
    //   this.titleDialog = "Edit Laporan";
    //   this.isUpdate = true;

    //   form.tgl_mulai = this.$moment(
    //     form.tgl_mulai,
    //     "DD-MM-YYYY hh:mm:ss"
    //   ).format("YYYY-MM-DD");
    //   form.tgl_selesai = this.$moment(
    //     form.tgl_selesai,
    //     "DD-MM-YYYY hh:mm:ss"
    //   ).format("YYYY-MM-DD");
    //   // form.kandungan_pancasila = form.kandungan_pancasila.split(',')
    //   this.form = form;
    // },
    // resetForm() {
    //   this.form = {
    //     judul: "",
    //     deskripsi: "",
    //     evidences: [],
    //     tgl_mulai: "",
    //     tgl_selesai: "",
    //     pelaksana_kegiatan: "",
    //     tautan: "",
    //     kategori_kegiatan: "",
    //     sumber_pembiayaan: "",
    //     segmen_kegiatan: "",
    //     tempat_kegiatan: "",
    //     aktif: true,
    //     kandungan_pancasila: "",
    //   };
    // },
    // handleCurrentChange(val) {
    //   this.page = val;
    // },
    // onSubmit(type = "store") {
    //   this.btnLoader = true;
    //   let url = "/lapor/store";
    //   if (type == "update") {
    //     url = `/lapor/${this.form.id}/update`;
    //   }
    //   let pancasila = "";
    //   if (Array.isArray(this.form.kandungan_pancasila)) {
    //     this.form.kandungan_pancasila.forEach((e) => {
    //       if (e !== "") {
    //         pancasila += pancasila == "" ? e : "," + e;
    //       }
    //     });
    //   }
    //   this.form.kandungan_pancasila =
    //     pancasila !== "" ? pancasila : this.form.kandungan_pancasila;
    //   this.$axios
    //     .post(url, this.form)
    //     .then((resp) => {
    //       if (resp.data.success) {
    //         this.$notify.success({
    //           title: "Success",
    //           message: `Berhasil ${
    //             type == "store" ? "Menambah" : "Mengubah"
    //           } Laporan`,
    //         });
    //         this.tambahDialog = false;
    //         this.resetForm();
    //         this.$store.dispatch("lapor/getAll", {});
    //       }
    //     })
    //     .finally(() => {
    //       this.btnLoader = false;
    //     })
    //     .catch((err) => {
    //       let error = err.response.data.data;
    //       if (error) {
    //         this.showErrorField(error);
    //       } else {
    //         this.$notify.error({
    //           title: "Error",
    //           message: err.response.data.message,
    //         });
    //       }
    //     });
    // },
    // deleteLaporan(id) {
    //   this.$swal({
    //     title: "Perhatian!",
    //     text: "Apakah anda yakin ingin menghapus data ini?",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Ya",
    //     cancelButtonText: "Batal",
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       this.$axios
    //         .delete(`/lapor/${id}/delete`)
    //         .then((resp) => {
    //           if (resp.data.success) {
    //             this.$notify.success({
    //               title: "Success",
    //               message: "Berhasil Menghapus Data",
    //             });
    //             this.tambahDialog = false;
    //             this.$store.dispatch("lapor/getAll", {
    //               defaultPage: true,
    //             });
    //           }
    //         })
    //         .finally(() => {
    //           //
    //         })
    //         .catch((err) => {
    //           this.$notify.error({
    //             title: "Error",
    //             message: err.response.data.message,
    //           });
    //         });
    //     }
    //   });
    // },
  },
  computed: {
    // ...mapGetters("lapor", ["getLapors", "getLoader"]),
    // ...mapGetters("setting", ["getSetting"]),
    // ...mapGetters("goverment", ["getGovermentPlains"]),
    ...mapGetters("employee", [
      "getEmployees",
      "getLoader"
    ]),
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
