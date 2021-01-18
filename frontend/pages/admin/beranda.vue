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
                  <div class="row">
                    <div class="col"></div>
                  </div>
                  <h1 class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap"
                      ><b>Good day Mr. Kafabih</b>
                    </span>
                  </h1>
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
          <el-card style="margin-top: 20px">
            <!-- Card header -->
            <div slot="header" class="clearfix d-flex justify-content-between">
              <!-- Title -->
              <h2>Attendance</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp;
              <span>{{ $moment(Date.now()).format("dddd, DDD MMMM YYYY") }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <vs-button
                  circle
                  shadow
                  size="xl"
                  :active="active == 2"
                  @click="active = 2"
                >
                  <img src="../../assets/img/fingerprint.png" alt="yes">
                </vs-button>
              </div>
              <div class="col-6 d-flex">
                <div class="row col-12">
                  <table>
                    <tr>
                      <h1 v-text="currentTime"></h1>
                    </tr>
                    <tr>
                      <td>Press the left-side button <br> to make an attendance</td>
                    </tr>
                  </table>
                </div>
                <!-- <div class="col-xl-12">
                    <p>Click the left side button to make an attendance</p>
                  </div> -->
              </div>
            </div>
          </el-card>
        </div>
        <div class="col-xl-6">
          <el-card class="mt-10" style="margin-top: 20px">
            <!-- Card header -->
            <div slot="header" class="clearfix d-flex justify-content-between">
              <!-- Title -->
              <h2>Today Attendances</h2>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              <span>{{ $moment(Date.now()).format("dddd, DDD MMMM YYYY") }}</span>
            </div>
            <div class="row">
              <div class="col-4">
                <img
                  class="rounded-circle"
                  src="https://picsum.photos/125/125/?image=58"
                  alt="Right image"
                />
              </div>
              <div class="col-2 d-flex">
                <h2 class="align-self-center">
                  Kafabih <br />
                  <p>yow</p>
                </h2>
              </div>
              <div class="col-6 d-flex">
                <vs-button
                  class="align-self-center"
                  size="xl"
                  shadow
                  :active="active == 1"
                  @click="active = 1"
                >
                  07.30
                </vs-button>

                <vs-button
                  class="align-self-center"
                  size="xl"
                  shadow
                  :active="active == 1"
                  @click="active = 1"
                >
                  Awesome
                </vs-button>
              </div>
            </div>

            <!-- <client-only>
              <ChartDoughnut />
            </client-only> -->
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ChartBar from "@/components/chart/chart-bar";
// import ChartDoughnut from "@/components/chart/chart-doughnut";
import ChartLine from "@/components/chart/chart-line";

import { mapMutations, mapGetters } from "vuex";

export default {
  components: {
    ChartBar,
    // ChartDoughnut,
    ChartLine,
  },
  layout: "admin",
  data() {
    return {
      searchGoverment: '',
      message: "Current Time:",
      currentTime: null,
      // summary: {
      //     laporan: {
      //       type: "up",
      //       current: 0,
      //       previous: 0,
      //       precentage: 0
      //     },
      //     kegiatan: {
      //       type: "up",
      //       current: 0,
      //       previous: 0,
      //       precentage: 0
      //     },
      //     berita: {
      //       type: "up",
      //       current: 0,
      //       previous: 0,
      //       precentage: 0
      //     },
      //   },
      //   beritaPopuler: [],
      //   loadingBeritaPopuler: true,
      // }
      
        
  }
  },
  mounted() {
      // this.getSummary();
      // this.getBeritaPopuler();
      // this.$store.dispatch('goverment/getPlains', {
      //   showall: 0
      // });
  },
  methods: {
    updateCurrentTime() {
      this.currentTime = moment().format("LTS");
    },
  },
  created() {
    this.currentTime = moment().format("LTS");
    setInterval(() => this.updateCurrentTime(), 1 * 1000);
  },
  // searchData() {
  //       this.$store.dispatch('service/getChartLaporanMasuk', {
  //         type: 'segmentasi',
  //         goverment: this.searchGoverment
  //       })
  //       this.$store.dispatch('service/getChartLaporanMasuk', {
  //         type: 'kategori',
  //         goverment: this.searchGoverment
  //       })
  //       this.$store.dispatch('service/getChartLaporanMasuk', {
  //         type: 'time',
  //         goverment: this.searchGoverment
  //       })
  //     },
  //     async getSummary() {
  //       await this.$axios.get('/summary').then(response => {
  //         if (response.data.success) {
  //           this.summary = response.data.data
  //         }
  //       }).catch(e => {
  //         console.log(e)
  //       })
  //     },
  //     async getBeritaPopuler() {
  //       await this.$axios.get('/berita-populer').then(response => {
  //         if (response.data.success) {
  //           this.beritaPopuler = response.data.data
  //         }
  //       }).finally(() => {
  //         this.loadingBeritaPopuler = false
  //       })
  //     },
  computed: {
    // ...mapGetters("goverment", ["getGovermentPlains"]),
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
