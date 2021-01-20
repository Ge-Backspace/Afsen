<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Pemerintah Daerah</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader">
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
                  <vs-th>Logo</vs-th>
                  <vs-th>Nama Pemda Prov/Kab/Kota</vs-th>
                  <vs-th>Aktif</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getGoverments.data" :data="tr">
                  <vs-td class="text-center">
                    <img :src="tr.foto_url" alt="" height="30" width="auto">
                  </vs-td>
                  <vs-td>
                    {{ tr.nama }}
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.aktif">Aktif</span>
                    <span class="badge badge-warning" v-else>Non Aktif</span>
                  </vs-td>
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteGoverment(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getGoverments.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getGoverments.total / table.max)" />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Pemda Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Pemerintah Daerah'">
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

    <vs-dialog v-model="tambahDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()">
      <template #header>
        <h1 class="not-margin">
          {{titleDialog}}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Nama</label>
            <vs-input type="text" v-model="form.nama" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Logo</label>
            <el-upload :action="api_url + '/fake-upload'" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
              :file-list="files" :limit="1">
              <i class="el-icon-plus"></i>
            </el-upload>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <vs-row>
              <vs-col w="2">
                <label>Aktif</label>
              </vs-col>
              <vs-col w="10">
                <vs-switch style="width:20px" v-model="form.aktif" />
              </vs-col>
            </vs-row>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding:5px">
              <vs-button block :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</vs-button>
              <vs-button block :loading="btnLoader" @click="onSubmit('store')" v-else>Simpan</vs-button>
            </vs-col>
            <vs-col w="6" style="padding:5px">
              <vs-button block border @click="tambahDialog = false; resetForm()">Batal</vs-button>
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
  </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  import {
    config
  } from '../../../global.config'

  export default {
    layout: 'admin',
    components: {

    },
    data() {
      return {
        api_url: config.baseApiUrl,
        table: {
          max: 10
        },
        page: 1,
        titleDialog: 'Tambah Pemda',
        search: '',
        isUpdate: false,
        tambahDialog: false,
        btnLoader: false,
        files: [],
        form: {
          nama: '',
          foto: null,
          aktif: true
        }
      }
    },
    mounted() {
      this.$store.dispatch('goverment/getAll', {});
    },
    methods: {
      searchData(){
        this.$store.dispatch('goverment/getAll', {
          search: this.search
        });
      },
      edit(data) {
        this.form.nama = data.nama
        this.form.id = data.id
        this.form.aktif = data.aktif
        this.files.push({
          name: '',
          url: data.foto_url
        })
        this.tambahDialog = true
        this.titleDialog = 'Edit Pemerintah Daerah'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          nama: '',
          foto: null,
          aktif: true
        }
        this.files = [];
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('goverment/setPage', val)
        this.$store.dispatch('goverment/getAll', {});
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("nama", this.form.nama)
        formData.append("aktif", this.form.aktif ? 1 : 0)
        if (this.form.foto !== null) {
          formData.append("foto", this.form.foto)
        }
        let url = "/goverment/store";
        if (type == 'update') {
          url = `/goverment/${this.form.id}/update`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Goverment`
            })
            this.resetForm()
            this.tambahDialog = false
            this.$store.dispatch('goverment/getAll', {});
          }
        }).finally(() => {
          this.btnLoader = false
        }).catch(err => {
          let error = err.response.data.data
          if (error) {
            this.showErrorField(error)
          } else {
            this.$notify.error({
              title: 'Error',
              message: err.response.data.message
            })
          }
        })
      },
      handleChangeFile(file, fileList) {
        this.form.foto = file.raw
      },
      deleteGoverment(id) {
        this.$swal({
          title: 'Perhatian!',
          text: "Apakah anda yakin ingin menghapus data ini?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            this.$axios.delete(`/goverment/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('goverment/getAll', {
                  defaultPage: true
                });
              }
            }).finally(() => {
              //
            }).catch(err => {
              this.$notify.error({
                title: 'Error',
                message: err.response.data.message
              })
            })
          }
        })
      }
    },
    computed: {
      ...mapGetters("goverment", [
        'getGoverments',
        'getLoader'
      ])
    },
    watch: {
      getGoverments(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('goverment/getAll', {
        //   search: newValue
        // });
      },
      page(newValue, oldValue) {
        this.$store.commit('goverment/setPage', newValue)
        this.$store.dispatch('goverment/getAll', {});
      }
    },
  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }

</style>
