<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Data Employees</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-6">
          <el-card style="margin-top: 20px">
            <div class="row">
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Add Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Bulk Add Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Update Employee
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Transfer History
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> PTKP Status
                </vs-button>
              </div>
              <div class="col-4">
                <vs-button
                  color="rgb(59,222,200)"
                  gradient
                  :active="active == 6"
                  @click="active = 6"
                >
                  <i class="bx bxs-purchase-tag"></i> Other Import
                </vs-button>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader" style="margin-top: 80px">
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
                  <vs-th>No</vs-th>
                  <vs-th>Fullname</vs-th>
                  <vs-th>Nip</vs-th>
                  <vs-th>Position</vs-th>
                  <vs-th>Status</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getEmployees.data" :data="tr">
                  <vs-td>
                    {{ i+1 }}
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.nip }}
                  </vs-td>
                  <vs-td>
                    {{ tr.positions_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.status }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip content="Edit" placement="top-start" effect="dark">
                      <el-button size="mini" @click="edit(tr)" icon="fa fa-edit"></el-button>
                    </el-tooltip>

                    <el-tooltip content="Delete" placement="top-start" effect="dark">
                      <el-button size="mini" type="primary" @click="deleteCompany(tr.id)" icon="fa fa-trash">
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{getEmployees.total}} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination v-model="page" :length="Math.ceil(getEmployees.total / table.max)" />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Laporan Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          tambahDialog = true;
        "
      >
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
            <label>Nama</label>
            <vs-input type="text" v-model="form.name" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Nip</label>
            <vs-input type="text" v-model="form.address" placeholder="Address"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Nip</label>
            <vs-input type="text" v-model="form.address" placeholder="Address"></vs-input>
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
import { mapMutations, mapGetters } from "vuex";

export default {
  layout: "admin",
  data() {
    return {
      data:{

      },
      company_id: '',
      table: {
        max: 10,
      },
      page: 1,
      current_page: 1,
      titleDialog: 'Tambah Karyawan',
      tambahDialog: false,
      search: "",
      isUpdate: false,
      btnLoader: false,
      form: {
        name: '',
        nip: '',
        position_name: '',
        status: '',
      },
      active:'',
      searchDate: ["", ""],
      searchGoverment: "",
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id))
    this.$store.dispatch('employee/getAll', {company_id: this.company_id})
    this.$axios.get(`/employees?company_id=${this.company_id}`).then(resp =>{
      console.log(resp)
    })
  },
  methods: {
    searchData(){
        this.$store.dispatch('employee/getAll', {
          search: this.search
        });
      },
      edit(data) {
        this.form.id = data.id
        this.form.name = data.name
        this.form.address = data.address
        this.tambahDialog = true
        this.titleDialog = 'Edit Employee'
        this.isUpdate = true
      },
      resetForm() {
        this.form = {
          name: '',
          address: '',
        }
        this.isUpdate = false
      },
      handleCurrentChange(val) {
        this.$store.commit('company/setPage', val)
        this.$store.dispatch('company/getAll', {});
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let formData = new FormData()
        formData.append("name", this.form.name)
        formData.append("address", this.form.address)
        let url = "/company/store";
        if (type == 'update') {
          url = `/company/update/${this.form.id}`
        }
        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil ${type == 'store' ? 'Menambah' : 'Mengubah'} Company`
            })
            this.resetForm()
            this.tambahDialog = false
            this.$store.dispatch('company/getAll', {});
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
            this.$axios.delete(`/company/delete/${id}`).then(resp => {
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
      }
  },
  computed: {
    // ...mapGetters("lapor", ["getLapors", "getLoader"]),
    // ...mapGetters("setting", ["getSetting"]),
    // ...mapGetters("goverment", ["getGovermentPlains"]),
    ...mapGetters("employee", [
      "getEmployees",
      "getLoader"
    ]),
  },
  watch: {
    // getLapors(newValue, oldValue) {},
    // getSetting(newValue, oldValue) {
    //   console.log(newValue);
    // },
    // search(newValue, oldValue) {
    //   // this.$store.dispatch('lapor/getAll', {
    //   //   search: newValue
    //   // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit("lapor/setPage", newValue);
    //   this.$store.dispatch("lapor/getAll", {});
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
