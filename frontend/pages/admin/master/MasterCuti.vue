<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Cuti</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <vs-button
                warn
                style="float: right"
                :loading="globalLoader"
                gradient
                @click="exportData('pdf')"
                >Download PDF</vs-button
              >
              &nbsp;
              <vs-button
                success
                style="float: right"
                :loading="globalLoader"
                gradient
                @click="exportData('excel')"
                >Download Excel</vs-button
              >
            </div>
          </div>
          <el-card v-loading="getLoader">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-2">
                <vs-button
                  success
                  style="float: right"
                  :loading="globalLoader"
                  gradient
                  @click="
                  importDialog = true
                  titleDialog = 'Import Master Cuti'
                  "
                  >Import Excel</vs-button
                >
              </div>
              <div class="col-md-3 offset-md-7">
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
                  <vs-th>Name</vs-th>
                  <vs-th>Code</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getCutis.data" :data="tr">
                  <vs-td>
                    {{ tr.cuti_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.code }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteCuti(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getCutis.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getCutis.total / table.max)" />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Cuti Baru" placement="top-start">
      <a class="float" @click="cutiDialog = true; titleDialog = 'Tambah Cuti'">
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button -->

    <!-- <el-dialog :title="titleDialog" :visible.sync="cutiDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'" @closed="resetForm()">
      <el-form label-width="auto" ref="form" :model="form" size="mini">
        <el-form-item label="Hari">
          <el-input v-model="form.hari"></el-input>
        </el-form-item>
        <el-form-item label="Cuti In">
          <el-time-picker v-model="form.Cuti_out"></el-time-picker>
        </el-form-item>
        <el-form-item size="large">
          <el-button type="primary" :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</el-button>
          <el-button type="primary" :loading="btnLoader" @click="onSubmit" v-else>Simpan</el-button>
          <el-button @click="cutiDialog = false">Batal</el-button>
        </el-form-item>
      </el-form>
    </el-dialog> -->

    <vs-dialog v-model="cutiDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
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
            <vs-input type="text" v-model="form.cuti_name" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Code</label>
            <vs-input type="text" v-model="form.code" placeholder="Code"></vs-input>
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
              <vs-button block border @click="cutiDialog = false; resetForm()">Batal</vs-button>
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
          <vs-input<input type="file" id="file" ref="file" @change="onFileChange"/>
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
                @click="importData()"
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
        company_id: '',
        table: {
          max: 10
        },
        page: 1,
        titleDialog: '',
        importDialog: false,
        search: '',
        company_id : JSON.parse(JSON.stringify(this.$auth.user.company_id)),
        isUpdate: false,
        cutiDialog: false,
        btnLoader: false,
        form: {
          id: '',
          cuti_name: '',
          code: '',
        }
      }
    },
    mounted() {
      this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
      this.$store.dispatch('cuti/getAll', {
        company_id: this.company_id
      });
    },
    methods: {
      searchData(){
        this.$store.dispatch('cuti/getAll', {
          search: this.search,
          company_id: this.company_id
        });
      },
      edit(data) {
        // console.log(moment(data.Cuti_in,"HH:mm:ss").format("HH:mm"))
        this.form.id = data.id
        this.form.cuti_name = data.cuti_name
        this.form.code = data.code
        this.cutiDialog = true
        this.titleDialog = 'Edit Data Cuti'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          id: '',
          cuti_name: '',
          code: '',
        }
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('cuti/setPage', val)
        this.$store.dispatch('cuti/getAll', {
          company_id: this.company_id
        });
      },
      onFileChange(e){
        this.file = e.target.files[0];
      },
      importData(){
        let formData = new FormData();
        formData.append('company_id', this.company_id);
        formData.append('file', this.file);
        this.$axios.post('/cuti/import', formData, {
          headers: {'content-type': 'multipart/form-data' }
        })
        .then(resp => {
          if(resp.data.success){
            this.$notify.success({
              title: 'Success',
              message: 'Berhasil Import Cuti'
            })
            this.resetForm()
            this.importDialog = false
            this.$store.dispatch('cuti/getAll', {
              company_id: this.company_id
            });
          }
        })
        .catch(error => {
          this.uploading = false
          this.error = error.resp.data
          console.log('check error: ', this.error)
        })
        .finally(() => {
          this.btnLoader = false
        })
      },
      exportData(type = 'excel'){
        if (type == 'pdf') {
          this.export_as = 'pdf'
        }
        this.$axios.get(`/cuti/export?company_id=${this.company_id}&as=${this.export_as}`, {
          responseType: 'blob'
        }).then((response) => {
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(
            new Blob([response.data])
          );
          if (type == 'pdf') {
            link.setAttribute('download','cuti.pdf');
          } else {
            link.setAttribute('download','cuti.xlsx');
          }
          document.body.appendChild(link);
          link.click();
        });
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("id", this.form.id)
        formData.append("company_id", this.company_id)
        formData.append("cuti_name", this.form.cuti_name)
        formData.append("code", this.form.code)
        let url = "/cuti";
        if (type == 'update') {
          url = `/cuti/${this.form.id}/update`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Cuti`
            })
            this.resetForm()
            this.cutiDialog = false
            this.$store.dispatch('cuti/getAll', {
              company_id: this.company_id
            });
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
      deleteCuti(id) {
        this.$swal({
          title: 'HEY WAIT!, HEY HOLD ON!',
          text: "Are you serious to delete this cutie data ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes Yes Yes',
          cancelButtonText: 'Yes but actually NO!'
        }).then((result) => {
          if (result.isConfirmed) {
            this.$axios.delete(`/cuti/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.cutiDialog = false
                this.$store.dispatch('cuti/getAll', {
                  defaultPage: true,
                  company_id: this.company_id
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
      // formatTime(time){
      //   return moment(time, "HH:mm:ss").format('HH:mm');
      // }
    },
    computed: {
      ...mapGetters('cuti', [
        'getCutis',
        'getLoader'
      ])
    },
    watch: {
      getCutis(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        this.$store.dispatch('cuti/getAll', {
          search: newValue
        });
      },
      page(newValue, oldValue) {
        this.$store.commit('cuti/setPage', newValue)
        this.$store.dispatch('cuti/getAll', {
          company_id: this.company_id
        });
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
