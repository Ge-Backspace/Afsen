<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Kagiatan</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/kegiatan/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/kegiatan/download/xlsx`)">Download Excel</vs-button>
        </div>
      </div>
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
              <vs-th>Judul</vs-th>
              <vs-th>Dilihat</vs-th>
              <vs-th>Tanggal Mulai</vs-th>
              <vs-th>Tanggal Selesai</vs-th>
              <vs-th>Aktif</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getKegiatans.data" :data="tr">
              <vs-td>
                {{ truncateString(tr.judul, 70) }}
              </vs-td>
              <vs-td>
                {{ tr.dilihat }}
              </vs-td>
              <vs-td>
                {{ tr.tgl_mulai }}
              </vs-td>
              <vs-td>
                {{ tr.tgl_selesai }}
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
                  <el-button size="mini" type="primary" @click="deleteKegiatan(tr.id)" icon="fa fa-trash"></el-button>
                </el-tooltip>
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{getKegiatans.total}} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination v-model="page" :length="Math.ceil(getKegiatans.total / table.max)" />
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </el-card>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Kegiatan Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Kegiatan'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button-->

    <vs-dialog v-model="tambahDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()">
      <template #header>
        <h1 class="not-margin">
          {{titleDialog}}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Judul</label>
            <vs-input type="text" v-model="form.judul" placeholder="Judul"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Deskripsi</label>
            <client-only>
              <vue-editor v-model="form.deskripsi"></vue-editor>
            </client-only>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tanggal Mulai</label>
            <vs-input type="date" v-model="form.tgl_mulai"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tanggal Selesai</label>
            <vs-input type="date" v-model="form.tgl_selesai"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Evidence</label>
            <el-upload class="upload-demo" list-type="picture-card" :action="api_url + '/fake-upload'" :on-change="handleChangeFile"
              accept="image/*" :file-list="files" v-if="!isUpdate">
              <i class="el-icon-plus"></i>
            </el-upload>
            <el-upload class="upload-demo" name="evidence" list-type="picture-card" :action="api_url + `/kegiatan/${form.id}/evidence/store`" :headers="headers" :on-change="handleChangeFile"
              accept="image/*" :file-list="files" :on-remove="handleRemove" v-else>
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
  } from '../../global.config'

  export default {
    layout: 'admin',
    components: {

    },
    data() {
      return {
        api_url: '',
        headers: {
          // 'Authorization': 'Bearer ' + this.$axios.g
        },
        table: {
          max: 10
        },
        page: 1,
        titleDialog: 'Tambah Kegiatan',
        tambahDialog: false,
        search: '',
        isUpdate: false,
        btnLoader: false,
        files: [],
        datePicker: ['', ''],
        form: {
          judul: '',
          deskripsi: '',
          aktif: true,
          evidences: [],
          tgl_mulai: '',
          tgl_selesai: ''
        }
      }
    },
    mounted() {
      this.headers = this.$axios.defaults.headers.common
      this.api_url = config.baseApiUrl
      this.$store.dispatch('kegiatan/getAll', {});
    },
    methods: {
      searchData() {
        this.$store.dispatch('kegiatan/getAll', {
          search: this.search
        });
      },
      handleSuccess(response, file, fileList){
        this.$notify.success({
          title: 'Success',
          message: 'Berhasil Menambah Evidence'
        })
      },
      handleRemove(file, fileList) {
        if (file.id) {
          this.$axios.delete(`/kegiatan/${this.form.id}/evidence/${file.id}/delete`).then(resp => {
            if (resp.data.success) {
              this.$notify.success({
                title: 'Success',
                message: 'Berhasil Menghapus Evidence'
              })
            }
          }).catch(e => {
            this.$notify.error({
              title: 'Error',
              message: e.response.data.message
            })
          }).finally(() => {
            //
          })
        }
      },
      edit(data) {
        let form = JSON.parse(JSON.stringify(data))
        this.form.judul = data.judul
        this.form.id = data.id
        this.form.aktif = data.aktif
        this.form.deskripsi = data.deskripsi
        this.form.tgl_mulai =  this.$moment(form.tgl_mulai, 'DD-MM-YYYY hh:mm:ss').format('YYYY-MM-DD'); 
        this.form.tgl_selesai = this.$moment(form.tgl_selesai, 'DD-MM-YYYY hh:mm:ss').format('YYYY-MM-DD'); 

        data.evidence.forEach((element, index) => {
          this.files.push({
            name: 'Evidence ' + index,
            url: element.file_url,
            id: element.id_file
          })
        });
        console.log(this.files)
        this.tambahDialog = true
        this.titleDialog = 'Edit Kegiatan'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          judul: '',
          deskripsi: '',
          aktif: true,
          evidences: [],
          tgl_mulai: '',
          tgl_selesai: ''
        }
        this.datePicker = ['', '']
        this.files = [];
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('kegiatan/setPage', val)
        this.$store.dispatch('kegiatan/getAll', {});
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("judul", this.form.judul)
        formData.append("deskripsi", this.form.deskripsi)
        formData.append("tgl_mulai", this.form.tgl_mulai)
        formData.append("tgl_selesai", this.form.tgl_selesai)
        formData.append("aktif", this.form.aktif ? 1 : 0)
        if (this.form.evidences.length !== 0) {
          this.form.evidences.forEach((item, index) => {
            formData.append(`evidence[${index}]`, item.raw)
          })
        }
        let url = "/kegiatan/store";
        if (type == 'update') {
          url = `/kegiatan/${this.form.id}/update`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Kegiatan`
            })
            this.tambahDialog = false
            this.$store.dispatch('kegiatan/getAll', {});
            this.resetForm()
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
        this.form.evidences = fileList
      },
      deleteKegiatan(id) {
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
            this.$axios.delete(`/kegiatan/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('kegiatan/getAll', {
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
      },
    },
    computed: {
      ...mapGetters("kegiatan", [
        'getKegiatans',
        'getLoader'
      ])
    },
    watch: {
      getKegiatans(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('kegiatan/getAll', {
        //   search: newValue
        // });
      },
      datePicker(newValue, oldValue) {
        console.log(newValue)
        if (newValue !== null && newValue.length !== 0) {
          this.form.tgl_mulai = newValue[0]
          this.form.tgl_selesai = newValue[1]
        }
      },
      page(newValue, oldValue) {
        this.$store.commit('kegiatan/setPage', newValue)
        this.$store.dispatch('kegiatan/getAll', {});
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
