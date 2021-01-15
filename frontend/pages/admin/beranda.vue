<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row" style="padding-top:20px">
            <div class="col-xl-4">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"><i class="las la-book-reader"></i> Laporan
                      </h5>
                      <span class="h2 font-weight-bold mb-0">{{numberWithCommas(summary.laporan.current)}}
                      </span>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span
                      :class="{'text-precentage': true, 'text-success': summary.laporan.type == 'up', 'text-primary': summary.laporan.type == 'down', 'mr-2': true}"><i
                        :class="{'las': true, 'la-angle-double-up': summary.laporan.type == 'up', 'la-angle-double-down': summary.laporan.type == 'down'}"></i>
                      <b>{{summary.laporan.precentage}}%</b></span>
                    <span class="text-nowrap">Dari bulan lalu</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"><i class="las la-chalkboard-teacher"></i>
                        Kegiatan</h5>
                      <span class="h2 font-weight-bold mb-0">{{numberWithCommas(summary.kegiatan.current)}}
                      </span>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span
                      :class="{'text-precentage': true, 'text-success': summary.kegiatan.type == 'up', 'text-primary': summary.kegiatan.type == 'down', 'mr-2': true}"><i
                        :class="{'las': true, 'la-angle-double-up': summary.kegiatan.type == 'up', 'la-angle-double-down': summary.kegiatan.type == 'down'}"></i>
                      <b>{{summary.kegiatan.precentage}}%</b></span>
                    <span class="text-nowrap">Dari bulan lalu</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"><i class="las la-coins"></i> Berita</h5>
                      <span class="h2 font-weight-bold mb-0">{{numberWithCommas(summary.berita.current)}}</span>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span
                      :class="{'text-precentage': true, 'text-success': summary.berita.type == 'up', 'text-primary': summary.berita.type == 'down', 'mr-2': true}"><i
                        :class="{'las': true, 'la-angle-double-up': summary.berita.type == 'up', 'la-angle-double-down': summary.berita.type == 'down'}"></i>
                      <b>{{summary.berita.precentage}}%</b></span>
                    <span class="text-nowrap">Dari bulan lalu</span>
                  </p>
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
              <h5 class="h3 mb-0">Berita Populer</h5>
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
              <h5 class="h3 mb-0">Laporan Per Kandungan Pancasila</h5>
            </div>
            <client-only>
              <ChartDoughnut />
            </client-only>
          </el-card>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 text-center" style="margin-top:20px">
          <label><b>Pemerintah Daerah</b></label>
          <el-select size="mini" clearable filterable v-model="searchGoverment" @change="searchData()" placeholder="Pilih Pemda"
            style="width:100%">
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
        <div class="col-md-12">
          <el-card style="margin-top:20px">
            <div class="row">
              <div class="col-md-6">
                <ChartLine />
              </div>
              <div class="col-md-6">
                <ChartBar />
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ChartBar from "@/components/chart/chart-bar";
  import ChartDoughnut from "@/components/chart/chart-doughnut";
  import ChartLine from "@/components/chart/chart-line";

  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  export default {
    components: {
      ChartBar,
      ChartDoughnut,
      ChartLine
    },
    layout: 'admin',
    data() {
      return {
        searchGoverment: '',
        summary: {
          laporan: {
            type: "up",
            current: 0,
            previous: 0,
            precentage: 0
          },
          kegiatan: {
            type: "up",
            current: 0,
            previous: 0,
            precentage: 0
          },
          berita: {
            type: "up",
            current: 0,
            previous: 0,
            precentage: 0
          },
        },
        beritaPopuler: [],
        loadingBeritaPopuler: true,
      }
    },
    mounted() {
      this.getSummary()
      this.getBeritaPopuler()
      this.$store.dispatch('goverment/getPlains', {
        showall: 0
      });
      // this.getPopularCourses()
    },
    methods: {
      searchData() {
        this.$store.dispatch('service/getChartLaporanMasuk', {
          type: 'segmentasi',
          goverment: this.searchGoverment
        })
        this.$store.dispatch('service/getChartLaporanMasuk', {
          type: 'kategori',
          goverment: this.searchGoverment
        })
        this.$store.dispatch('service/getChartLaporanMasuk', {
          type: 'time',
          goverment: this.searchGoverment
        })
      },
      async getSummary() {
        await this.$axios.get('/summary').then(response => {
          if (response.data.success) {
            this.summary = response.data.data
          }
        }).catch(e => {
          console.log(e)
        })
      },
      async getBeritaPopuler() {
        await this.$axios.get('/berita-populer').then(response => {
          if (response.data.success) {
            this.beritaPopuler = response.data.data
          }
        }).finally(() => {
          this.loadingBeritaPopuler = false
        })
      },
    },
    computed: {
      ...mapGetters("goverment", [
        'getGovermentPlains'
      ]),
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
