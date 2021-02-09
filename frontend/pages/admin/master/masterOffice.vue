<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master Data Office</h1>
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
                  <vs-th>Office</vs-th>
                  <vs-th>Lang</vs-th>
                  <vs-th>Latitude</vs-th>
                  <vs-th>address</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getOffices.data" :data="tr">
                  <vs-td>
                    {{ tr.office_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.address }}
                  </vs-td>
                  <vs-td>
                    {{ tr.lat }}
                  </vs-td>
                  <vs-td>
                    {{ tr.lng }}
                  </vs-td>
                  <vs-td>
                    <el-tooltip
                      content="Edit"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        @click="
                        edit(tr),
                        request = false"
                        icon="fa fa-edit"
                      ></el-button>
                    </el-tooltip>

                    <el-tooltip
                      content="Delete"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        type="primary"
                        @click="deleteEmployee(tr.id)"
                        icon="fa fa-trash"
                      >
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getOffices.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getOffices.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader">
            <GmapMap
            v-bind:center="center"
            v-bind:zoom="8"
            map-type-id="terrain"
            style="height: 225px"
            >
            <GmapMarker
              v-bind:key="index"
              v-for="(m, index) in markers"
              v-bind:position="m.position"
            />
            </GmapMap>
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
          request = true;
          tambahDialog = true;
          titleDialog = 'Add Office';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button-->

    <!-- <vs-dialog
      v-model="tambahDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()"
    >
      <template #header>
        <h1 class="not-margin">
          {{ titleDialog }}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col
            v-if="request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Office Nama</label>
            <vs-input
              type="text"
              v-model="form.office_name"
              placeholder="Office Nama"
            ></vs-input>
          </vs-col>
          <vs-col
            v-if="request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Lat</label>
            <vs-input
              type="text"
              v-model="form.lat"
              placeholder="lat"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Lang</label>
            <vs-input
              type="number"
              v-model="form.lng"
              placeholder="Lang"
            ></vs-input>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('update')"
                v-if="isUpdate"
                >Update</vs-button
              >
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('store')"
                v-else
                >Simpan</vs-button
              >
            </vs-col>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                border
                @click="
                  tambahDialog = false;
                  resetForm();
                "
                >Batal</vs-button
              >
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog> -->
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
            <label>Nama Office</label>
            <vs-input type="text" v-model="form.office_name" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Latitude</label>
            <vs-input type="number" v-model="form.lat" placeholder="Latitude"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Longitude</label>
            <vs-input type="number" v-model="form.lng" placeholder="Longitude"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <GmapMap
            v-bind:center="{lat: Number(form.lat), lng: Number(form.lng)}"
            v-bind:zoom="16"
            map-type-id="terrain"
            style="height: 250px"
            >
            <GmapMarker
              v-bind:position="center"
              v-bind:clickable="true"
              v-bind:draggable="true"
              @drag="updateCoordinates"
            />
            </GmapMap>
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
      table: {
        max: 10,
      },

      request: false,
      error: {},
      active: "",
      option: [],
      page: 1,
      current_page: 1,
      titleDialog: "Tambah office",
      tambahDialog: false,
      search: '',
      company_id: JSON.parse(JSON.stringify(this.$auth.user.company_id)),
      isUpdate: false,
      btnLoader: false,
      form: {
        office_name: '',
        lat: '',
        lng: '',

      },
      center: {lat: -6.2, lng: 106.816666},
      markers: [],
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("office/getAll", { company_id: this.company_id });
    this.$axios.get(`/getCoordinate?company_id=${this.company_id}`)
    .then(resp => {
      let el = resp.data.data
      let positions = []
      this.center.lat = Number(el[0].position.lat)
      this.center.lng = Number(el[0].position.lng)
      el.forEach((value, index) => {
        positions[index] = {position: {lat: Number(value.position.lat), lng: Number(value.position.lng)}}
      });
      this.markers = positions
    })
  },
  methods: {
    searchData() {
      this.$store.dispatch("office/getAll", {
        company_id: this.company_id,
        search: this.search,
      });
    },
    // onFileChange(e){
    //   this.file = e.target.files[0];
    // },
    // importData(){
    //   let formData = new FormData();
    //   formData.append("company_id", this.company_id);
    //   formData.append('file', this.file);
    //   this.$axios.post('/employee/import', formData, {
    //     headers: {'content-type': 'multipart/form-data' }
    //   })
    //   .then(response => {
    //     if(response.status === 200){
    //       //...
    //     }
    //   })
    //   .catch(error => {
    //     this.uploading = false
    //     this.error = error.response.data
    //     console.log('check error: ', this.error)
    //   })
    // },
    // exportData(type = 'excel'){
    //   let as = 'excel'
    //   if (type == 'pdf') {
    //     as = 'pdf'
    //   }
    //   this.$axios.get(`/employee/export?company_id=${this.company_id}&as=${as}`, {
    //     //if u forgot this, your download will be corrupt
    //     responseType: 'blob'
    //   }).then((response) => {
    //     //create a link in the document that we'll
    //     //programmatically 'click'
    //     const link = document.createElement('a');

    //     //tell the browser to associate the response data
    //     //to the URL of the link we created above.
    //     link.href = window.URL.createObjectURL(
    //       new Blob([response.data])
    //     );


    //   //tell the browset to download, not render
    //   link.setAttribute('download','employee.xlsx');

    //   //place the link in the DOM.
    //   document.body.appendChild(link);

    //   //make the magic happen!
    //   link.click();
    //   }); //please catch me baby!
    // },
    edit(data) {
      this.form.id = data.id;
      this.form.office_name = data.office_name;
      this.form.lat = data.lat;
      this.form.lng = data.lng;
      this.tambahDialog = true;
      this.titleDialog = "Edit Office";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        office_name: '',
        lat: '',
        lang: '',

      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("office/setPage", val);
      this.$store.dispatch("office/getAll", { company_id: this.company_id });
    },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("office_name", this.form.office_name);
      formData.append("lat", this.form.lang);
      formData.append("lng", this.form.lng);
      console.log(this.form)
      let url = "/employee";
      if (type == "update") {
        url = `/office/${this.form.id}/update`;
      }
      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } Office`,
            });
            this.resetForm();
            this.tambahDialog = false;
            this.$store.dispatch("office/getAll", { company_id: this.company_id, });
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
    deleteEmployee(id) {
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
            .delete(`/office/${id}/delete`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.tambahDialog = false;
                this.$store.dispatch("employee/getAll", {
                  company_id: this.company_id,
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
    updateCoordinates(location) {
      this.form.lat = location.latLng.lat(),
      this.form.lng = location.latLng.lng()
    },
  },
  computed: {
    ...mapGetters("office", [
      "getOffices",
      "getLoader"
    ]),
    ...mapGetters("coordinate", [
      "getCoordinate",
      "getLoader"
    ]),
  },
  watch: {
    getOffices(newValue, oldValue){
      //
    },
    lat(newValue, oldValue) {
      this.form.lat = newValue
    },
    lng(newValue, oldValue) {
      this.form.lng = newValue
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
