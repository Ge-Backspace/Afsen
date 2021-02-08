<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">EEEEEEEEE</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--6">
      <el-card v-loading="getLoader">
        <div slot="header" class="clearfix">
          <div class="row">
            <div class="col-md-4">
              <span class="demonstration">tanggal</span>
              <br />
              <el-date-picker
                v-model="value1"
                type="monthrange"
                range-separator="-"
                start-placeholder="Start month"
                end-placeholder="End month"
                size="mini"
              >
              </el-date-picker>
            </div>
            <div class="col-md-3">
              <span>Select Employee</span>
              <br />
              <el-select
                v-model="select"
                slot="prepend"
                placeholder="All"
                size="mini"
                style="width: 180px"
              >
                <el-option label="1" value="1"></el-option>
                <el-option label="2" value="2"></el-option>
                <el-option label="3" value="3"></el-option>
              </el-select>
            </div>
            <div class="col-md-3 mt-3" style="">
              <vs-button
                primary
                relief
                size="small"
                :active="active == 5"
                @click="active = 5"
                style="width: 150px"
              >
                <i class="bx bx-check"></i> Lihat
              </vs-button>
            </div>
          </div>

          <!-- <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button> -->
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col-md-2">
            <span>Limit View</span>
            <br />
            <el-select
              style="width: 110px"
              v-model="select"
              slot="prepend"
              placeholder="limit"
              size="mini"
            >
              <el-option label="1" value="1"></el-option>
              <el-option label="2" value="2"></el-option>
              <el-option label="3" value="3"></el-option>
            </el-select>
          </div>
          <div class="col-md-3" >
            <span>search</span>
            <el-input
              placeholder="Cari"
              v-model="search"
              @change="searchData()"
              size="mini"
            >
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
          </div>
          <div class="col-md-2 offset-md-4" >
            <span>Download File</span>
            <br>
            <vs-button
                success
                relief
                size="small"
                :active="active == 5"
                @click="active = 5"
                style="width: 150px"
              >
                <i class="el el-icon-document"></i> Export Excel
              </vs-button>
          </div>
        </div>
        <p style="font-weight: bold;" class="text-center">JANUARY</p>
        
        <el-table :data="tableData" style="width: 100%" height="250">
          
          <el-table-column fixed prop="name" label="Name" width="150">
          </el-table-column>
          <el-table-column
            prop="zip"
            :label="col.tanggal"
            v-for="col in data"
            :key="col.id"
          ></el-table-column>
        </el-table>
      </el-card>
    </div>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

import { config } from "../../../../global.config";

export default {
  layout: "admin",
  components: {},
  data() {
    return {
      api_url: config.baseApiUrl,
      table: {
        max: 10,
      },
      page: 1,
      titleDialog: "Tambah Berita",
      tambahDialog: false,
      search: "",
      isUpdate: false,
      btnLoader: false,
      files: [],
      form: {
        judul: "",
        deskripsi: "",
        aktif: true,
        banner: null,
      },
      company_id: '',
      lastDate: '',
      tableData: [],
      data: [],
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.lastDate = Number(moment().clone().endOf('month').format('DD'))
    console.log(this.lastDate)
    for (let i = 0; i <= this.lastDate; i++) {
      this.data.push({
        tanggal: i,
      });
    }
    this.$store.dispatch('report/getAttendance',{
      company_id: this.company_id,
      startDate: moment().clone().startOf('month').format('YYYY-MM-DD'),
      endDate: moment().clone().endOf('month').format('YYYY-MM-DD')
    })
  },
  methods: {
    searchData() {
      this.$store.dispatch("berita/getAll", {
        search: this.search,
      });
    },
    edit(data) {
      this.form.judul = data.judul;
      this.form.id = data.id;
      this.form.aktif = data.aktif;
      this.form.deskripsi = data.deskripsi;
      this.files.push({
        name: "",
        url: data.banner_url,
      });
      this.tambahDialog = true;
      this.titleDialog = "Edit Berita";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        judul: "",
        banner: null,
        aktif: true,
        deskripsi: "",
      };
      this.files = [];
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("berita/setPage", val);
      this.$store.dispatch("berita/getAll", {});
    },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("judul", this.form.judul);
      formData.append("deskripsi", this.form.deskripsi);
      formData.append("aktif", this.form.aktif ? 1 : 0);
      if (this.form.banner !== null) {
        formData.append("banner", this.form.banner);
      }
      let url = "/berita/store";
      if (type == "update") {
        url = `/berita/${this.form.id}/update`;
      }

      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Berita`,
            });
            this.tambahDialog = false;
            this.$store.dispatch("berita/getAll", {});
            this.resetForm();
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
    handleChangeFile(file, fileList) {
      this.form.banner = file.raw;
    },
    deleteBerita(id) {
      console.log("delete");
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
            .delete(`/berita/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.tambahDialog = false;
                this.$store.dispatch("berita/getAll", { defaultPage: true });
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
    ...mapGetters('report', ['getAttendance', 'getLoader']),
  },
  watch: {
    // getBeritas(newValue, oldValue) {},
    // search(newValue, oldValue) {
    //   // this.$store.dispatch('berita/getAll', {
    //   //   search: newValue
    //   // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit("berita/setPage", newValue);
    //   this.$store.dispatch("berita/getAll", {});
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
