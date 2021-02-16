<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row" style="padding-top: 20px">
            <div class="col-xl-12">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <h1 class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap" style="font-size: 24px"
                      ><b>Good day {{ this.name }}</b>
                    </span>
                  </h1>
                  <!-- <div class="row">
                    <div class="col"></div>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- popular couses -->
      <div class="row">
        <div class="col-xl-6">
          <!-- card pre-present -->
          <el-card
            style="margin-top: 20px; background-color: #0f0967"
            v-if="
              this.status == 0 &&
              this.startDay &&
              this.startCheckin &&
              !this.startCheckout
            "
          >
            <!-- Card header -->
            <div
              class="clearfix d-flex justify-content-between"
              style="margin-bottom: 20px"
            >
              <!-- Title -->
              <h2 style="color: #ffffff">Attendance</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span>{{
                $moment(Date.now()).format("dddd, DD MMMM YYYY")
              }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  :loading="showLoading"
                  circle
                  info
                  size="xl"
                  :active="active == 2"
                  @click="checkin('checkin')"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes" />
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 v-text="currentTime"></h1>
                    </tr>
                    <tr>
                      <td>
                        Press the left-side button <br />
                        to make an attendance
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </el-card>
          <!-- card after present -->
          <el-card
            style="margin-top: 20px; background-color: #3b31c7"
            v-else-if="
              this.status == 0 &&
              this.startDay &&
              !this.startCheckin &&
              !this.startCheckout
            "
          >
            <!-- Card header -->
            <div
              class="clearfix d-flex justify-content-between"
              style="margin-bottom: 20px"
            >
              <!-- Title -->
              <h2 style="color: #ffffff">Attendance</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span style="color: #ffffff">{{
                $moment(Date.now()).format("dddd, DD MMMM YYYY")
              }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  :loading="showLoading"
                  circle
                  warning
                  size="xl"
                  :active="active == 2"
                  @click="checkin('checkin')"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes" />
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 style="color: #ffffff" v-text="currentTime"></h1>
                    </tr>
                    <tr>
                      <td style="color: #ffffff">
                        Press the left-side button <br />
                        to make an attendance
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </el-card>
          <!-- card present late -->
          <el-card
            style="margin-top: 20px; background-color: #d01919"
            v-else-if="
              this.status == 0 &&
              this.startDay &&
              !this.startCheckin &&
              this.startCheckout
            "
          >
            <!-- Card header -->
            <div
              class="clearfix d-flex justify-content-between"
              style="margin-bottom: 20px"
            >
              <!-- Title -->
              <h2>Attendance</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span style="color: #ffffff">{{
                $moment(Date.now()).format("dddd, DD MMMM YYYY")
              }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  :loading="showLoading"
                  circle
                  danger
                  size="xl"
                  :active="active == 2"
                  @click="checkin('checkin')"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes" />
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 v-text="currentTime" style="color: #ffffff"></h1>
                    </tr>
                    <tr>
                      <td style="color: #ffffff">
                        Press the left-side button <br />
                        to make an attendance
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </el-card>
          <!-- card present absent -->
          <el-card
            style="margin-top: 20px; background-color: #4cb63f"
            v-else-if="this.status == 1"
          >
            <!-- Card header -->
            <div
              class="clearfix d-flex justify-content-between"
              style="margin-bottom: 20px"
            >
              <!-- Title -->
              <h2 style="color: #ffffff">test</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span style="color: #ffffff">{{
                $moment(Date.now()).format("dddd, DD MMMM YYYY")
              }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  :loading="showLoading"
                  circle
                  success
                  size="xl"
                  :active="active == 2"
                  @click="checkin('checkout')"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes" />
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 v-text="currentTime" style="color: #ffffff"></h1>
                    </tr>
                    <tr>
                      <td style="color: #ffffff">
                        Press the left-side button <br />
                        to make an attendance
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </el-card>
          <!-- card finish -->
          <el-card style="margin-top: 20px; background-color: #909399" v-else>
            <!-- Card header -->
            <div slot="header" class="clearfix d-flex justify-content-between">
              <!-- Title -->
              <h2>Attendance</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span>{{
                $moment(Date.now()).format("dddd, DD MMMM YYYY")
              }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  :loading="showLoading"
                  circle
                  Info
                  size="xl"
                  :active="active == 2"
                  @click="checkout('dayoff')"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes" />
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 v-text="currentTime"></h1>
                    </tr>
                    <tr>
                      <td>
                        Press the left-side button <br />
                        to make an attendance
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </el-card>
        </div>
        <div class="col-xl-6">
          <!-- left card-->
          <el-card
            class="mt-10"
            style="margin-top: 20px; width: 450px; height: 500px"
          >
            <!-- Card header -->
            <div slot="header" class="clearfix d-flex justify-content-between">
              <!-- Title -->
              <h2 style="font-size: 16px">Today Attendances</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              <span
                >Schedule In : {{ schedule_in }}<br />Schedule Out :
                {{ schedule_out }}</span
              >
            </div>
            <table>
              <tr :key="i" v-for="(tr, i) in getCheckin.data" :data="tr">
                <td>
                  <p
                    style="font-weight: bold; font-size: 16px;"
                    class="clearfix"
                  >
                    <img
                      style="float: left; width: 42px; height: 42px;"
                      class="rounded-circle"
                      src="https://picsum.photos/125/125/?image=58"
                      alt="left image"
                    />
                    &nbsp; &nbsp;
                    {{ tr.name }}
                    <br />
                    &nbsp; &nbsp;
                    <span style="font-weight: normal; font-size: 14px"
                      >{{ tr.position_name }}</span
                    >
                  </p>
                </td>
                <br /><br />
                <td>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  &nbsp; &nbsp; &nbsp;
                </td>
                <td>
                  <vs-avatar
                    v-if="!tr.checkout_time"
                    size="10"
                    class="align-self-center"
                    danger
                    style="height: 20px; width: 80px; border-radius: 15px"
                  >
                    <span style="font-weight: ">{{
                      formatTime(tr.checkin_time)
                    }}</span>
                  </vs-avatar>

                  <vs-avatar
                    v-else
                    size="10"
                    class="align-self-center"
                    success
                    style="height: 20px; width: 80px; border-radius: 15px"
                  >
                    <span style="font-weight: ">{{
                      formatTime(tr.checkin_time)
                    }}</span>
                  </vs-avatar>
                </td>
                <td>
                  <vs-avatar
                    v-if="tr.status == 0"
                    size="20"
                    class="align-self-center"
                    success
                    style="
                      height: 20px;
                      width: 80px;
                      border-radius: 15px;
                      margin-left: 20px;
                    "
                  >
                    <span style="font-weight: ">Excelent</span>
                  </vs-avatar>
                  <vs-avatar
                    v-else
                    size="10"
                    class="align-self-center"
                    danger
                    style="
                      height: 20px;
                      width: 80px;
                      border-radius: 15px;
                      margin-left: 20px;
                    "
                  >
                    <span style="font-weight: ">Late</span>
                  </vs-avatar>
                </td>
              </tr>
            </table>
          </el-card>
        </div>
      </div>
    </div>
    <vs-dialog
      v-model="earlyCheckout"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="earlyCheckout = false"
    >
      <template #header>
        <h1 class="not-margin">
          Early Checkout
        </h1>
      </template>
      <vs-row>
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="8"
          style="padding: 5px"
        >
          <label>Reason</label>
          <client-only>
            <vue-editor v-model="form.reason"></vue-editor>
          </client-only>
        </vs-col>
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="4"
          style="padding: 5px"
        >
          <label>Upload Document</label>
          <el-upload
            :action="api_url + '/fake-upload'" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
          :file-list="files" :limit="1"
          >
            <i class="el-icon-plus"></i>
          </el-upload>
        </vs-col>
      </vs-row>
      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding: 5px">
              <vs-button block :loading="btnLoader"
              @click="eCheckout()"
                >Simpan</vs-button
              >
            </vs-col>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                border
                @click="
                  earlyCheckout = false;
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
import { mapMutations, mapGetters } from "vuex";
import * as moment from "moment";

export default {
  components: {},
  layout: "admin",
  data() {
    return {
      api_url: '',
      active: 0,
      status: 0,
      company_id: "",
      table: {
        max: 10,
      },
      startDay: false,
      startCheckin: false,
      startCheckout: false,
      btnLoader: false,
      earlyCheckout: false,
      name: "",
      data: {
        user_id: "",
        lat: "",
        lng: "",
        request: "",
      },
      form: {
        checkin_id: "",
        reason: "",
        files: "",
      },
      employee_id: "",
      start: "06:00:00",
      currentTime: null,
      showLoading: false,
      schedule_in: "",
      schedule_out: "",
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.data.user_id = JSON.parse(JSON.stringify(this.$auth.user.id));
    this.$axios.get(`/getName?user_id=${this.data.user_id}`).then((resp) => {
      this.name = resp.data.data;
    });
    this.$store.dispatch("checkin/getAll", {
      showall: 1,
      company_id: this.company_id,
    });
    this.$getLocation({}).then((coordinates) => {
      this.data.lat = coordinates.lat;
      // this.data.lat = -6.7615122;
      this.data.lng = coordinates.lng;
      // this.data.lng = 108.4114873;
    });
    this.$axios.get(`/check?user_id=${this.data.user_id}`).then((response) => {
      this.$notify.success({
        title: "Check",
        message: response.data.message,
      });
      this.status = response.data.data.status;
    });
    this.$axios
      .get(`/todayShiftEmployee?user_id=${this.data.user_id}`)
      .then((response) => {
        this.schedule_in = response.data.data.schedule_in;
        this.schedule_out = response.data.data.schedule_out;
      });
    this.$axios
      .get(`positions/?user_id=${this.data.user_id}`)
      .then((response) => {
        this.position_name = response.data.data.position_name;
      });
    let now = moment(this.currentTime, "HH:mm:ss A").format("HH:mm:ss");
    if (moment(this.start, "HH:mm:ss") <= moment(now, "HH:mm:ss")) {
      this.startDay = true;
    } else if (
      moment(this.schedule_in, "HH:mm:ss") <= moment(now, "HH:mm:ss")
    ) {
      this.startCheckin = true;
    } else if (
      moment(this.schedule_out, "HH:mm:ss") <= moment(now, "HH:mm:ss")
    ) {
      this.startCheckout = true;
    }
  },
  methods: {
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("employee_id", this.form.employee_id);
      formData.append("cuti_id", this.form.cuti_id);
      formData.append("start_date", this.form.start_date);
      formData.append("expired_date", this.form.expired_date);
      formData.append("reason", this.form.reason);
      // formData.append("file", this.file);
      if (this.form.files) {
        formData.append("file", this.form.files)
      }
      console.log(formData)
      // let url = "/checkout";
      // if (type == "update") {
      //   url = `cutipermission/${this.form.id}/update`;
      // }

      // this.$axios
      //   .post(url, formData)
      //   .then((resp) => {
      //     if (resp.data.success) {
      //       this.$notify.success({
      //         title: "Success",
      //         message: `Berhasil ${
      //           type == "store" ? "Menambah" : "Mengubah"
      //         } Shift Employee`,
      //       });
      //       this.resetForm();
      //       this.seDialog = false;
      //       this.$store.dispatch("cutipermission/getAll", {
      //         company_id: this.company_id,
      //       });
      //     }
      //   })
      //   .finally(() => {
      //     this.btnLoader = false;
      //   })
      //   .catch((err) => {
      //     let error = err.response.data.data;
      //     if (error) {
      //       this.showErrorField(error);
      //     } else {
      //       this.$notify.error({
      //         title: "Error",
      //         message: err.response.data.message,
      //       });
      //     }
      //   });
    },
    handleChangeFile(file, fileList) {
      console.log(file);
      this.form.files = file.raw;
    },
    checkin(type = "checkin") {
      this.showLoading = true;
      this.data.request = 1;
      if (type == "checkout") {
        this.data.request = 2;
      }
      this.$axios
        .post("/checkin", this.data)
        .then((response) => {
          this.$notify.success({
            title: "Berhasil",
            message: response.data.message,
          });
          // this.$router.push('/admin/beranda')
          this.$store.dispatch("checkin/getAll", {
            showall: 1,
            company_id: this.company_id,
          });
          this.$axios
            .get(`/check?user_id=${this.data.user_id}`)
            .then((response) => {
              this.$notify.success({
                title: "Check",
                message: response.data.message,
              });
              this.status = response.data.data.status;
            });
        })
        .catch((e) => {
          if (e.response.data.code == 409) {
            this.$swal({
              title: 'Perhatian!',
              text: "Apakah anda yakin ingin checkout Lebih Awal ?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                this.earlyCheckout = true
                this.form.checkin_id = e.response.data.data.checkin
                console.log(this.form.checkin_id)
              }
            })
          }
          this.$notify.error({
            title: "Error",
            message: e.response.data.message,
          });
        })
        .finally(() => {
          this.showLoading = false;
        });
    },
    eCheckout() {
      this.btnLoader = true;
      let formData = new FormData();
      formData.append("company_id", this.company_id);
      formData.append("employee_id", this.form.employee_id);
      formData.append("cuti_id", this.form.cuti_id);
      formData.append("start_date", this.form.start_date);
      formData.append("expired_date", this.form.expired_date);
      formData.append("reason", this.form.reason);
      // formData.append("file", this.file);
      if (this.form.files) {
        formData.append("file", this.form.files)
      }
      console.log(formData)
    },
    lCheckin() {
      //
    },
    checkout(type = "checkout") {
      this.$notify.error({
        title: "Gagal",
        message: `Anda ${
          type == "dayoff" ? "Tidak ada Schedule" : "Sudah Checkout"
        } Hari Ini`,
      });
    },
    updateCurrentTime() {
      this.currentTime = moment().format("LTS");
    },
    formatTime(time) {
      return moment(String(time)).format("HH:mm");
    },
  },
  created() {
    this.currentTime = moment().format("LTS");
    setInterval(() => this.updateCurrentTime(), 1 * 1000);
  },
  computed: {
    ...mapGetters("checkin", [
      "getCheckin",
      // 'getLoader',
      // 'getSummary'
    ]),
    ...mapGetters("position", [
      "getPositions",
      // 'getLoader',
      // 'getSummary'
    ]),
  },
};
</script>

<style lang="scss" scoped>
.text-precentage {
  font-size: 14px;
  font-weight: bold;
}

span.top-nama > a > span.el-link--inner {
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  white-space: nowrap !important;
  width: 150px !important;
}
</style>
