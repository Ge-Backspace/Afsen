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

              <div class="row" :key="i" v-for="(tr, i) in getCheckin.data" :data="tr">
                <div class="col-4">
                  <img
                    class="rounded-circle"
                    src="https://picsum.photos/125/125/?image=58"
                    alt="Right image"
                  />
                </div>
                <div class="col-2 d-flex">
                  <h2 class="align-self-center">
                    {{ tr.name }}
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
                    {{ formatTime(tr.checkin_time) }}
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

          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {
    mapMutations,
    mapGetters
  } from 'vuex';

export default {
  components: {

  },
  layout: "admin",
  data() {
    return {
      active: '',
      company_id: '',
      table: {
        max: 10
      },
      currentTime: null,
  }
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch('checkin/getAll', {
      showall: 1,
      company_id: this.company_id
    });
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch('checkin/getAll', {
      showall: 1,
      company_id: this.company_id
    });
  },
  methods: {
    updateCurrentTime() {
      this.currentTime = moment().format("LTS");
    },
    formatTime(time){
      return moment(String(time)).format('hh:mm');
    }
  },
  created() {
    this.currentTime = moment().format("LTS");
    setInterval(() => this.updateCurrentTime(), 1 * 1000);
  },
  computed: {
    ...mapGetters("checkin", [
      'getCheckin',
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
