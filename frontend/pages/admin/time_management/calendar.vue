<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Calendar</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-6 offset-sm-7 row">
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
                </vs-button>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <el-calendar v-model="value"> </el-calendar>
              </div>
              <div class="col-4 card text-white bg-primary mb-3">
                <div class="card-head text-center" style="margin-top: 20px">What's on January ?</div>
                <div class="card-body">
                  <h5 class="card-title"></h5>
                  <p class="card-text">
                    Some quick example text to build on the card title and make
                    up the bulk of the card's content.
                  </p>
                </div>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Pemda Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          tambahDialog = true;
          titleDialog = 'Tambah Pemerintah Daerah';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button-->

    <!-- <el-dialog :title="titleDialog" :visible.sync="tambahDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'" @closed="resetForm()">
      <el-form label-width="auto" ref="form" :model="form" size="mini">
        <el-form-item label="Nama Kementrian">
          <el-input v-model="form.nama"></el-input>
        </el-form-item>
        <el-form-item label="Logo">
          <el-upload action="/" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
            :file-list="files" :limit="1">
            <i class="el-icon-plus"></i>
          </el-upload>
        </el-form-item>
        <el-form-item label="Aktif">
          <el-switch v-model="form.aktif" color="danger"></el-switch>
        </el-form-item>
        <el-form-item size="large">
          <el-button type="primary" :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</el-button>
          <el-button type="primary" :loading="btnLoader" @click="onSubmit" v-else>Simpan</el-button>
          <el-button @click="tambahDialog = false">Batal</el-button>
        </el-form-item>
      </el-form>
    </el-dialog> -->
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
      page: 1,
      titleDialog: "Tambah Pemda",
      search: "",
      isUpdate: false,
      tambahDialog: false,
      btnLoader: false,
      files: [],
      form: {
        nama: "",
        foto: null,
        aktif: true,
      },
      newDate: null,
    };
  },
  mounted() {
    this.$store.dispatch("goverment/getAll", {});
  },
  methods: {
    searchData() {
      this.$store.dispatch("goverment/getAll", {
        search: this.search,
      });
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
      this.$store.commit("goverment/setPage", val);
      this.$store.dispatch("goverment/getAll", {});
    },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("nama", this.form.nama);
      formData.append("aktif", this.form.aktif ? 1 : 0);
      if (this.form.foto !== null) {
        formData.append("foto", this.form.foto);
      }
      let url = "/goverment/store";
      if (type == "update") {
        url = `/goverment/${this.form.id}/update`;
      }

      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Goverment`,
            });
            this.resetForm();
            this.tambahDialog = false;
            this.$store.dispatch("goverment/getAll", {});
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
      this.form.foto = file.raw;
    },
    deleteGoverment(id) {
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
            .delete(`/goverment/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.tambahDialog = false;
                this.$store.dispatch("goverment/getAll", {
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
    ...mapGetters("goverment", ["getGoverments", "getLoader"]),
  },
  watch: {
    getGoverments(newValue, oldValue) {},
    search(newValue, oldValue) {
      // this.$store.dispatch('goverment/getAll', {
      //   search: newValue
      // });
    },
    page(newValue, oldValue) {
      this.$store.commit("goverment/setPage", newValue);
      this.$store.dispatch("goverment/getAll", {});
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
