<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Attendance</h1>
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
            @click="exportData(`pdf`)"
            >Download PDF</vs-button
          >
          &nbsp;
          <vs-button
            success
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="exportData(`excel`)"
            >Download Excel</vs-button
          >
          <el-card v-loading="getLoader" style="margin-top: 40px">
            <div class="row" style="margin-bottom: 20px">
              <div class="row col-7">
                <vs-button 
                  :active="active == 0" 
                  @click="
                  active = 0;
                  reportDialog = true;
                  titleDialog = 'View Report Attendance'; 
                  ">
                    <i class="bx bx-home-alt"></i> Attendance Report
                </vs-button>

                <!-- <vs-button
                  danger
                  border
                  :active="active == 2"
                  @click="
                    active = 2;
                    tambahDialog = true;
                    titleDialog = 'Import Method Attendance';
                  "
                >
                  <i class="bx bxs-heart"></i> Import Method
                </vs-button>

                <vs-button
                  warn
                  gradient
                  :active="active == 3"
                  @click="
                  active = 3;
                  $router.push('setting');
                  "
                >
                  <i class="bx bxs-bell-ring"></i> Attendance Setting
                </vs-button> -->

                <!-- <vs-button
                  color="#7d33ff"
                  relief
                  :active="active == 5"
                  @click="
                  active = 5;
                  $router.push('timeoff_deduction');
                  "
                >
                  <i class="bx bxs-paper-plane"></i> Absence-Timeoff Deduction
                </vs-button> -->
              </div>
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
                  <vs-th>Address</vs-th>
                  <vs-th>Checkin Time</vs-th>
                  <vs-th>Checkout Time</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr
                  :key="i"
                  v-for="(tr, i) in getAttendances.data"
                  :data="tr"
                >
                  <vs-td>
                    {{ i + 1 }}
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.address }}
                  </vs-td>
                  <vs-td>
                    {{ tr.checkin_time }}
                  </vs-td>
                  <vs-td>
                    {{ tr.checkout_time }}
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getAttendances.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getAttendances.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    
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
      active: 0,
      company_id: '',
      table: {
        max: 10,
      },
      page: 1,
      search: "",
      tambahDialog: false,
      btnLoader: false,
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("attendance/getAll", {
      company_id: this.company_id
    });
    this.$axios.get(`/attendance?company_id=${this.company_id}`).then(resp => {
      console.log(resp)
    })
  },
  methods: {
    searchData() {
      this.$store.dispatch("attendance/getAll", {
        search: this.search,
      });
    },
    exportData(type = 'excel'){
      let as = 'excel'
      if (type == 'pdf') {
        as = 'pdf'
      }
      this.$axios.get(`/attendance/export?company_id=${this.company_id}&as=${as}`, {
        //if u forgot this, your download will be corrupt
        responseType: 'blob'
      }).then((response) => {
        //create a link in the document that we'll
        //programmatically 'click'
        const link = document.createElement('a');

        //tell the browser to associate the response data
        //to the URL of the link we created above.
        link.href = window.URL.createObjectURL(
          new Blob([response.data])
        );


      //tell the browset to download, not render
      link.setAttribute('download','employee.xlsx');

      //place the link in the DOM.
      document.body.appendChild(link);

      //make the magic happen!
      link.click();
      }); //please catch me baby!
    },
    edit(data) {
      this.form.nama = data.nama;
      this.form.id = data.id;
      this.form.aktif = data.aktif;
      this.files.push({
        name: "",
        url: data.foto_url,
      });
      this.tambahDialog = true;
      this.titleDialog = "Edit Pemerintah Daerah";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        nama: "",
        foto: null,
        aktif: true,
      };
      this.files = [];
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("attendance/setPage", val);
      this.$store.dispatch("attendance/getAll", {});
    },
    // onSubmit(type = "store") {
    //   this.btnLoader = true;
    //   let formData = new FormData();
    //   formData.append("nama", this.form.nama);
    //   formData.append("aktif", this.form.aktif ? 1 : 0);
    //   if (this.form.foto !== null) {
    //     formData.append("foto", this.form.foto);
    //   }
    //   let url = "/goverment/store";
    //   if (type == "update") {
    //     url = `/goverment/${this.form.id}/update`;
    //   }

    //   this.$axios
    //     .post(url, formData)
    //     .then((resp) => {
    //       if (resp.data.success) {
    //         this.$notify.success({
    //           title: "Success",
    //           message: `Berhasil ${
    //             type == "store" ? "Menambah" : "Mengubah"
    //           } Goverment`,
    //         });
    //         this.resetForm();
    //         this.tambahDialog = false;
    //         this.$store.dispatch("goverment/getAll", {});
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
    // handleChangeFile(file, fileList) {
    //   this.form.foto = file.raw;
    // },
    delete(id) {
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
            .delete(`/attendance/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.tambahDialog = false;
                this.$store.dispatch("attendance/getAll", {
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
    ...mapGetters("attendance", ["getAttendances", "getLoader"]),
  },
  watch: {
    getAttendance(newValue, oldValue) {},
    search(newValue, oldValue) {
      // this.$store.dispatch('goverment/getAll', {
      //   search: newValue
      // });
    },
    page(newValue, oldValue) {
      this.$store.commit("attendance/setPage", newValue);
      this.$store.dispatch("attendance/getAll", {
        company_id: this.company_id
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
