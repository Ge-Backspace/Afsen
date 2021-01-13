<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Informasi</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/xlsx`)">Download Excel</vs-button>
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
              <vs-th>Tanggal Posting</vs-th>
              <vs-th>Aktif</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getInformations.data" :data="tr">
              <vs-td>
                  {{ truncateString(tr.judul, 70) }}
              </vs-td>
              <vs-td>
                {{ tr.dilihat }}
              </vs-td>
              <vs-td>
                {{ tr.created_at }}
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
                  <el-button size="mini" type="primary" @click="deleteInformasi(tr.id)" icon="fa fa-trash"></el-button>
                </el-tooltip>
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{getInformations.total}} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination v-model="page" :length="Math.ceil(getInformations.total / table.max)" />
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </el-card>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Berita Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Informasi'">
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
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
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
              <vs-button block :loading="btnLoader"  @click="onSubmit('update')" v-if="isUpdate">Update</vs-button>
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

  export default {
    layout: 'admin',
    components: {

    },
    data() {
      return {
        table: {
          max: 10
        },
        page: 1,
        titleDialog: 'Tambah Informasi',
        tambahDialog: false,
        search: '',
        isUpdate: false,
        btnLoader: false,
        form: {
          judul: '',
          deskripsi: '',
          aktif: true
        }
      }
    },
    mounted() {
      this.$store.dispatch('informasi/getAll', {});
    },
    methods: {
      searchData(){
        this.$store.dispatch('informasi/getAll', {
          search: this.search
        });
      },
      edit(data) {
        this.form = JSON.parse(JSON.stringify(data))
        this.tambahDialog = true
        this.titleDialog = 'Edit Informasi'
        this.isUpdate = true
      },
      resetForm(){ 
        this.form ={
          judul: '',
          deskripsi: '',
          aktif: true
        },
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('informasi/setPage', val)
        this.$store.dispatch('informasi/getAll', {});
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let url = "/information/store";
        if (type == 'update') {
          url = `/information/${this.form.id}/update`
        }

        this.$axios.post(url, this.form).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Informasi`
            })
            this.tambahDialog = false
            this.$store.dispatch('informasi/getAll', {});
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
      deleteInformasi(id) {
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
            this.$axios.delete(`/information/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('informasi/getAll', {defaultPage:true});
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
      ...mapGetters("informasi", [
        'getInformations',
        'getLoader'
      ]),
    },
    watch: {
      getInformations(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('informasi/getAll', {
        //   search: newValue
        // });
      },
      page(newValue, oldValue) {
        this.$store.commit('berita/setPage', newValue)
        this.$store.dispatch('berita/getAll', {});
      }
    }
  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }

</style>
