<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Berita</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--6">
      <el-card v-loading="getLoader">
        <div class="row" style="margin-bottom: 20px">
          <div class="col-md-3 offset-md-9">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="Pick a day"
            >
            </el-date-picker>
          </div>
          <div class="col-md-3 md-9">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="Pick a day"
            >
            </el-date-picker>
          </div>
        </div>
        <el-table :data="tableData" style="width: 100%" height="250">
          
          <el-table-column fixed prop="name" label="Employee" width="150"> </el-table-column>
            <el-table-column prop="zip" :label="col.tanggal" v-for="col in data" :key="col.id"></el-table-column>
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
      data: []
    };
  },
  mounted() {
    this.$store.dispatch("berita/getAll", {});

    for(let i = 0; i <= 30; i++){
      this.data.push({
        tanggal: i
      })
    }
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
    ...mapGetters("berita", ["getBeritas", "getLoader"]),
  },
  watch: {
    getBeritas(newValue, oldValue) {},
    search(newValue, oldValue) {
      // this.$store.dispatch('berita/getAll', {
      //   search: newValue
      // });
    },
    page(newValue, oldValue) {
      this.$store.commit("berita/setPage", newValue);
      this.$store.dispatch("berita/getAll", {});
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
