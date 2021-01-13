<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row" style="padding-top:20px">
            <div class="col-xl-12">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h1 class="h3 mb-0">Hai {{ name_user }}, apa kabar ?</h1>
                      <h5 class="h3 mb-0" v-text="currentTime"></h5>
                    </div>
                  </div>
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
          <el-card style="margin-top:20px">
            <!-- Card header -->
            <div slot="header" class="clearfix">
              <!-- Title -->
              <div class="row">
                <div class="col-md-6">
                  <div class="flex flex-row">
                    <h5 class="h3 mb-0" v-text="currentTime"></h5>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="flex flex-row-reverse">
                    <h5 class="h3 mb-0" v-text="currentTime"></h5>
                  </div>
                </div>
              </div>
            </div>
            <el-table :data="beritaPopuler" stripe v-loading="loadingBeritaPopuler">
              <el-table-column type="index" width="50" align="center">
              </el-table-column>
              <el-table-column label="Judul Berita">
                <template slot-scope="scope">
                  <el-tooltip class="item" effect="dark" :content="scope.row.judul" placement="top">
                    <!-- <router-link :to="`/admin/pembelajaran/kursus/view?id=${scope.row.id}`"> -->
                    <el-link type="primary" class="text-truncate">{{truncateString(scope.row.judul, 50)}}</el-link>
                    <!-- </router-link> -->
                  </el-tooltip>
                </template>
              </el-table-column>
              <el-table-column label="Dibaca" width="130" align="center">
                <template slot-scope="scope">
                  {{scope.row.total}}
                </template>
              </el-table-column>
            </el-table>
          </el-card>
        </div>
        <div class="col-xl-6">
          <el-card class="mt-10" style="margin-top:20px">
            <!-- Card header -->
            <div slot="header" class="clearfix">
              <!-- Title -->
              <h5 class="h3 mb-0 text-center"></h5>
            </div>
            <client-only>
              <!-- <ChartDoughnut /> -->
            </client-only>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  // import ChartBar from "@/components/chart/chart-bar";
  // import ChartDoughnut from "@/components/chart/chart-doughnut";

  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  export default {
    components: {
      // ChartBar,
      // ChartDoughnut,
    },
    layout: 'admin',
    data() {
      return {
        name_user: '',
        currentTime: null,
      }
    },
    mounted() {
      this.name_user = JSON.parse(JSON.stringify(this.$auth.user.name))
    },
    methods: {
      updateCurrentTime() {
            this.currentTime = moment().format("LTS");
        }
    },
    computed: {
      ...mapGetters("goverment", [
        'getGovermentPlains'
      ]),
    },
    created () {
      this.currentTime = moment().format("LTS");
        setInterval(() => this.updateCurrentTime(), 1 * 1000);
    },
  }

</script>

<style lang="scss" scoped>
  .text-precentage {
    font-size: 14px;
    font-weight: bold
  }

  span.top-nama>a>span.el-link--inner {
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    width: 150px !important;
  }

</style>
