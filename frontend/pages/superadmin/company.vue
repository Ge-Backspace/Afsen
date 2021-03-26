<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Companies</h1>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader" style="margin-top: 80px">
            <div class="row" style="margin-bottom: 20px">
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
                  <vs-th>Action</vs-th>
                  <vs-th>Name</vs-th>
                  <vs-th>Regist Date</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getCompany.data" :data="tr">
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteCompany(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip>

                    <el-tooltip content="User" placement="top-start" effect="dark">
                      <el-button size="mini" @click="userCompany(tr.id, tr.name)" icon="fa fa-user"></el-button>
                    </el-tooltip>
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.created_at) }}
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getCompany.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getCompany.total / table.max)" />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
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
</template>

<script>
  import {mapMutations, mapGetters} from 'vuex';
  import moment from 'moment';

  export default {
    layout: "superadmin",
    data() {
      return {
        table: {
          max: 10
        },
        page: 1,
        search: '',
        active: '',
        titleDialog: '',
        isUpdate: false,
        tambahDialog: false,
        btnLoader: false,
        form: {
          id: '',
          name: '',
        },
      }
    },
    mounted () {
    this.$store.dispatch('company/getAll',{
        //
      })
    },
    methods: {
      formatDate(date) {
        return moment(date).format("DD MMMM YYYY")
      },
      searchData(){
        this.$store.dispatch('company/getAll', {
          search: this.search
        });
      },
      handleCurrentChange(val) {
        this.$store.commit('company/setPage', val)
        this.$store.dispatch('company/getAll', {
          //
        });
      },
      userCompany(company_id, name) {
        console.log(company_id)
        this.$store.commit('company/setId', company_id)
        this.$store.commit('company/setName', name)
        this.$store.dispatch("user/getAll", {
          company_id: company_id,
        });
        this.$router.push('user')
      },
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
            this.$store.dispatch('company/getAll', {
              //
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
              }
            }).finally(() => {
              this.$store.dispatch('company/getAll', {
                defaultPage: true
              })
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
      ...mapGetters('company', ['getCompany', 'getLoader'])
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
