<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Lapor</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/lapor/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/lapor/download/xlsx`)">Download Excel</vs-button>
        </div>
      </div>
      <el-card v-loading="getLoader">
        <div class="row" style="margin-bottom:20px">
          <div class="col-md-4">
            <el-date-picker size="mini" type="daterange" range-separator="-" start-placeholder="Start date"
              end-placeholder="End date" style="width:100%" v-model="searchDate" value-format="yyyy-MM-dd" @change="searchData()">
            </el-date-picker>
          </div>
          <div class="col-md-4">
            <el-select size="mini" clearable filterable v-model="searchGoverment" @change="searchData()" placeholder="Pilih Pemda" style="width:100%">
              <el-option v-for="item in getGovermentPlains" :key="'gov-'+item.id" :label="item.nama" :value="item.id"
                style="height:60px">
                <div class="row">
                  <div class="col-2">
                    <span style="float: left"><img :src="item.foto_url" height="30" width="auto" alt=""></span>
                  </div>
                  <div class="col-10">
                    <span>{{ item.nama }}</span>
                  </div>
                </div>
              </el-option>
            </el-select>
          </div>
          <div class="col-md-4">
            <el-input placeholder="Cari" v-model="search" @change="searchData()" size="mini">
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
          </div>
        </div>
        <vs-table striped>
          <template #thead>
            <vs-tr>
              <vs-th>Judul</vs-th>
              <vs-th>Goverment</vs-th>
              <vs-th>Pelaksana Kegiatan</vs-th>
              <vs-th>Tempat Kegiatan</vs-th>
              <vs-th>Sumber Pembiayaan</vs-th>
              <vs-th>Segmen Kegiatan</vs-th>
              <vs-th>Tanggal Mulai</vs-th>
              <vs-th>Tanggal Selesai</vs-th>
              <vs-th>Aktif</vs-th>
              <vs-th>Action</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getLapors.data" :data="tr">
              <vs-td>
                  <el-link><a class="text-primary" @click="detailLaporan(tr)">{{ tr.judul }}</a></el-link>
              </vs-td>
              <vs-td>
                {{ tr.user ? (tr.user.goverment ? tr.user.goverment.nama : '-') : '-'}}
              </vs-td>
              <vs-td>
                {{ tr.pelaksana_kegiatan }}
              </vs-td>
              <vs-td>
                {{ tr.tempat_kegiatan }}
              </vs-td>
              <vs-td>
                {{ tr.sumber_pembiayaan }}
              </vs-td>
              <vs-td>
                {{ tr.segmen_kegiatan }}
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
                <el-tooltip content="Download Evidence" placement="top-start" effect="dark">
                  <el-button size="mini" @click="downloadFile(`lapor/${tr.id}/evidence/download`, true)" icon="fa fa-download"></el-button>
                </el-tooltip>

                <el-tooltip content="Edit" placement="top-start" effect="dark">
                  <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                </el-tooltip>

                <el-tooltip content="Delete" placement="top-start" effect="dark">
                  <el-button size="mini" type="primary" @click="deleteLaporan(tr.id)" icon="fa fa-trash"></el-button>
                </el-tooltip>
              </vs-td>
            </vs-tr>
          </template>
          <template #footer>
            <vs-row>
              <vs-col w="2">
                <small>Total : {{getLapors.total}} Data</small>
              </vs-col>
              <vs-col w="10">
                <vs-pagination v-model="page" :length="Math.ceil(getLapors.total / table.max)" />
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </el-card>
    </div>

    <!-- Floating Button -->
    <el-tooltip class="item" effect="dark" content="Buat Laporan Baru" placement="top-start">
      <a class="float" @click="tambahDialog = true; titleDialog = 'Tambah Laporan'">
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
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tempat Kegiatan</label>
            <vs-input type="text" v-model="form.tempat_kegiatan" placeholder="Tempat Kegiatan"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tanggal Mulai</label>
            <vs-input type="date" v-model="form.tgl_mulai"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tanggal Selesai</label>
            <vs-input type="date" v-model="form.tgl_selesai"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Tautan</label>
            <vs-input type="text" v-model="form.tautan" placeholder="Tautan"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Pelaksana Kegiatan</label>
            <vs-select filter placeholder="Pelaksana Kegiatan" v-model="form.pelaksana_kegiatan">
              <vs-option v-for="(item, index) in getSetting.pelaksana_kegiatan" :key="'pk-'+index" :label="item.value" :value="item.value">
                {{item.value}}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Sumber Pembiayaan</label>
            <vs-select filter placeholder="Sumber Pembiayaan" v-model="form.sumber_pembiayaan">
              <vs-option v-for="(item, index) in getSetting.sumber_pembiayaan" :key="'sp-'+index" :label="item.value" :value="item.value">
                {{item.value}}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Segmen Kegiatan</label>
            <vs-select filter placeholder="Sumber Pembiayaan" v-model="form.segmen_kegiatan">
              <vs-option v-for="(item, index) in getSetting.segmen_kegiatan" :key="'sg-'+index" :label="item.value" :value="item.value">
                {{item.value}}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Kategori Kegiatan</label>
            <vs-select filter placeholder="Kategori Kegiatan" v-model="form.kategori_kegiatan">
              <vs-option v-for="(item, index) in getSetting.kategori_kegiatan" :key="'kk-'+index" :label="item.value" :value="item.value">
                {{item.value}}
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col w="12" style="padding:5px">
            <label>Kandungan Nilai Pancasila</label>
            <vs-select filter multiple placeholder="Kategori Kegiatan" v-model="form.kandungan_pancasila">
              <vs-option label="KETUHANAN YANG MAHA ESA" :value="1">
                KETUHANAN YANG MAHA ESA
              </vs-option>
              <vs-option label="KEMANUSIAAN YANG ADIL DAN BERADAB" :value="2">
                KEMANUSIAAN YANG ADIL DAN BERADAB
              </vs-option>
              <vs-option label="PERSATUAN INDONESIA" :value="3">
                PERSATUAN INDONESIA
              </vs-option>
              <vs-option label="KERAKYATAN YANG DIPIMPIN OLEH HIKMAT KEBIJAKSANAAN DALAM PERMUSYAWARATAN/PERWAKILAN" :value="4">
                KERAKYATAN YANG DIPIMPIN OLEH HIKMAT KEBIJAKSANAAN DALAM PERMUSYAWARATAN/PERWAKILAN
              </vs-option>
              <vs-option label="KEADILAN SOSIAL BAGI SELURUH RAKYAT INDONESIA" :value="5">
                KEADILAN SOSIAL BAGI SELURUH RAKYAT INDONESIA
              </vs-option>
            </vs-select>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Deskripsi</label>
            <client-only>
              <vue-editor v-model="form.deskripsi" :editorToolbar="customToolbar"></vue-editor>
            </client-only>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Aktif</label>
            <vs-switch style="width:20px" v-model="form.aktif" />
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

  export default {
    layout: 'admin',
    data() {
      return {
        table: {
          max: 10
        },
        page: 1,
        customToolbar: [["bold", "italic", "underline"], [{ list: "ordered" }, { list: "bullet" }], [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}]],
        titleDialog: 'Tambah Laporan',
        tambahDialog: false,
        search: '',
        isUpdate: false,
        btnLoader: false,
        form: {
          judul: "",
          deskripsi: "",
          evidences: [],
          tgl_mulai: "",
          tgl_selesai: "",
          pelaksana_kegiatan: '',
          tautan: '',
          kategori_kegiatan: "",
          sumber_pembiayaan: '',
          segmen_kegiatan: '',
          tempat_kegiatan: '',
          aktif: true,
          kandungan_pancasila: ''
        },
        searchDate: ['', ''],
        searchGoverment: ''
      }
    },
    mounted() {
      this.$store.dispatch('lapor/getAll', {
        showall: 1
      });

      this.$store.dispatch('setting/getAll');
      this.$store.dispatch('goverment/getPlains', {
        showall: 0
      });
    },
    methods: {
      searchData(){
        let start_date = '';
        let end_date = '';
        if(this.searchDate){
          start_date = this.searchDate[0]
          end_date = this.searchDate[1]
        }
        this.$store.dispatch('lapor/getAll', {
          search: this.search,
          start_date: start_date,
          end_date: end_date,
          goverment: this.searchGoverment
        });
      },
      detailLaporan(data){
        this.$store.commit('lapor/setLaporan', data)
        this.$router.push('/admin/lapor/detail')
      },
      edit(data) {
        let form = JSON.parse(JSON.stringify(data))
        this.tambahDialog = true
        this.titleDialog = 'Edit Laporan'
        this.isUpdate = true

        form.tgl_mulai =  this.$moment(form.tgl_mulai, 'DD-MM-YYYY hh:mm:ss').format('YYYY-MM-DD'); 
        form.tgl_selesai = this.$moment(form.tgl_selesai, 'DD-MM-YYYY hh:mm:ss').format('YYYY-MM-DD'); 
        // form.kandungan_pancasila = form.kandungan_pancasila.split(',')
        this.form = form
      },
      resetForm() {
        this.form = {
          judul: "",
          deskripsi: "",
          evidences: [],
          tgl_mulai: "",
          tgl_selesai: "",
          pelaksana_kegiatan: '',
          tautan: '',
          kategori_kegiatan: "",
          sumber_pembiayaan: '',
          segmen_kegiatan: '',
          tempat_kegiatan: '',
          aktif: true,
          kandungan_pancasila: ''
        }
      },
      handleCurrentChange(val) {
        this.page = val;
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let url = "/lapor/store";
        if (type == 'update') {
          url = `/lapor/${this.form.id}/update`
        }
        let pancasila = '';
        if(Array.isArray(this.form.kandungan_pancasila)){
          this.form.kandungan_pancasila.forEach(e => {
              if(e !== ''){
                pancasila += pancasila == '' ? e : (',' + e)
              }
          });
        }
        this.form.kandungan_pancasila = pancasila !== '' ? pancasila : this.form.kandungan_pancasila;
        this.$axios.post(url, this.form).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Laporan`
            })
            this.tambahDialog = false
            this.resetForm()
            this.$store.dispatch('lapor/getAll', {});
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
      deleteLaporan(id) {
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
            this.$axios.delete(`/lapor/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('lapor/getAll', {
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
      ...mapGetters("lapor", [
        'getLapors',
        'getLoader'
      ]),
      ...mapGetters("setting", [
        'getSetting'
      ]),
      ...mapGetters("goverment", [
        'getGovermentPlains'
      ]),
    },
    watch: {
      getLapors(newValue, oldValue) {

      },
      getSetting(newValue, oldValue){
        console.log(newValue)
      },
      search(newValue, oldValue) {
        // this.$store.dispatch('lapor/getAll', {
        //   search: newValue
        // });
      },
      page(newValue, oldValue) {
        this.$store.commit('lapor/setPage', newValue)
        this.$store.dispatch('lapor/getAll', {});
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
