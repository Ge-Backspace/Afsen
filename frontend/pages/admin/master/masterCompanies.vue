<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Company</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader" style="margin-top: 80px">
            <vs-table striped>
              <template #thead>
                <vs-tr>
                  <vs-th>Name</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getCompany.data" :data="tr">
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <!-- <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteCompany(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip> -->
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
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
            <label>Nama</label>
            <vs-input type="text" v-model="form.name" placeholder="Nama"></vs-input>
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
        titleDialog: 'Edit Company',
        search: '',
        isUpdate: false,
        tambahDialog: false,
        btnLoader: false,
        company_id: '',
        form: {
          id: '',
          name: '',

        },
        center: {lat: 0, lng: 0},
        zoom: 16,
        markers:[],
        positions: {
          position: {lat: '', lng: ''}
        }
      }
    },
    mounted() {
      this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
      this.$store.dispatch('company/getCompany', {
        company_id: this.company_id
      });
      this.$axios.get(`/getCoordinate?company_id=${this.company_id}`)
      .then(resp => {
        this.center.lat = Number(resp.data.data.lat)
        this.center.lng = Number(resp.data.data.lng)
        this.positions.position = this.center
        this.markers.push(this.positions)
      })
    },
    methods: {
      // searchData(){
      //   this.$store.dispatch('company/getAll', {
      //     search: this.search
      //   });
      // },
      edit(data) {
        this.form.id = data.id
        this.form.name = data.name
        this.tambahDialog = true
        this.titleDialog = 'Edit Company'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          id: '',
          name: '',
        }
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('company/setPage', val)
        this.$store.dispatch('company/getCompany', {
          company_id: this.company_id
        });
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("name", this.form.name)
        let url = "/company/store";
        if (type == 'update') {
          url = `/company/${this.form.id}/update`
        }

        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Company`
            })
            this.resetForm()
            this.tambahDialog = false
            this.$store.dispatch('company/getCompany', {
              company_id: this.company_id
            });
            this.$axios.get(`/getCoordinate?company_id=${this.company_id}`)
            .then(resp => {
              this.center.lat = Number(resp.data.data.lat)
              this.center.lng = Number(resp.data.data.lng)
              this.positions.position = this.center
              this.markers.push(this.positions)
            })
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
      deleteCompany(id) {
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
            this.$axios.delete(`/company/${id}/delete`).then(resp => {
              if (resp.data.success) {
                this.$notify.success({
                  title: 'Success',
                  message: 'Berhasil Menghapus Data'
                })
                this.tambahDialog = false
                this.$store.dispatch('company/getAll', {
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
      updateCoordinates(location) {
        this.form.lat = location.latLng.lat(),
        this.form.lng = location.latLng.lng()
      }
    },
    computed: {
      ...mapGetters("company", [
        'getCompany',
        'getLoader'
      ]),
      ...mapGetters("coordinate", [
        'getCordinate',
        'getLoader'
      ])
    },
    watch: {
      getCompany(newValue, oldValue) {

      },
      search(newValue, oldValue) {
        // this.$store.dispatch('goverment/getAll', {
        //   search: newValue
        // });
      },
      // page(newValue, oldValue) {
      //   this.$store.commit('company/setPage', newValue)
      //   this.$store.dispatch('company/getCompany', {});
      // },
      lat(newValue, oldValue) {
        this.form.lat = newValue
      },
      lng(newValue, oldValue) {
        this.form.lng = newValue
      },
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
