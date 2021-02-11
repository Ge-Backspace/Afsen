<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Report Attendance</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-md-12">
          <br />
          <el-card v-loading="getLoader">
            <div slot="header" class="clearfix">
              <div class="row">
                <div class="col-md-4">
                  <span class="demonstration">tanggal</span>
                  <br />
                  <el-date-picker
                    v-model="value2"
                    type="month"
                    placeholder="Pick a month"
                    size="mini"
                  >
                  </el-date-picker>
                </div>
                <div class="col-md-3">
                  <span>Select Employee</span>
                  <br />
                  <el-select
                    v-model="select"
                    slot="prepend"
                    placeholder="All"
                    size="mini"
                    style="width: 180px"
                  >
                    <el-option label="1" value="1"></el-option>
                    <el-option label="2" value="2"></el-option>
                    <el-option label="3" value="3"></el-option>
                  </el-select>
                </div>
                <div class="col-md-3 mt-3" style="">
                  <vs-button
                    primary
                    relief
                    size="small"
                    :active="active == 5"
                    @click="active = 5"
                    style="width: 150px"
                  >
                    <i class="bx bx-check"></i> Lihat
                  </vs-button>
                </div>
              </div>

              <!-- <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button> -->
            </div>
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-2">
                <span>Limit View</span>
                <br />
                <el-select
                  style="width: 110px"
                  v-model="select"
                  slot="prepend"
                  placeholder="limit"
                  size="mini"
                >
                  <el-option label="1" value="1"></el-option>
                  <el-option label="2" value="2"></el-option>
                  <el-option label="3" value="3"></el-option>
                </el-select>
              </div>
              <div class="col-md-3">
                <span>search</span>
                <el-input
                  placeholder="Cari"
                  v-model="search"
                  @change="searchData()"
                  size="mini"
                >
                  <i slot="prefix" class="el-input__icon el-icon-search"></i>
                </el-input>
              </div>
              <div class="col-md-2 offset-md-4">
                <span>Download File</span>
                <br />
                <vs-button
                  success
                  relief
                  size="small"
                  :active="active == 5"
                  @click="active = 5"
                  style="width: 150px"
                >
                  <i class="el el-icon-document"></i> Export Excel
                </vs-button>
              </div>
            </div>
            <p style="font-weight: bold" class="text-center">
              {{ month(getAttendance.data[0].checkins[0].date) }}
            </p>
            <el-table
              :data="getAttendance.data"
              style="width: 100%"
              class="table-striped"
            >
              <el-table-column label="Nama" width="200px">
                <template slot-scope="scope">
                  <div>
                    {{ scope.row.name }}
                  </div>
                </template>
              </el-table-column>
              <el-table-column
                v-for="(h, i) in getAttendance.data[0].checkins"
                :data="h"
                :key="i"
                :label="dateLabel(h.date)"
                width="110px"
              >
                <div>{{ scope.row.checkins.checkin_time }} - {{ scope.row.checkins.checkout_time }}</div>
                
              </el-table-column>
            </el-table>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";
import * as moment from "moment";
import { config } from "../../../../global.config";

export default {
  layout: "admin",
  components: {},
  data() {
    return {
      active: "",
      select: "",
      api_url: config.baseApiUrl,
      table: {
        max: 10,
      },
      page: 1,
      titleDialog: "Tambah Berita",
      tambahDialog: false,
      search: "",
      isUpdate: false,
      btnLoader: false,
      files: [],
      company_id: "",
      lastDate: "",
      data: [
        
      ],
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.lastDate = Number(moment().clone().endOf("month").format("DD"));
    this.$store.dispatch("report/getAttendance", {
      company_id: this.company_id,
      startDate: moment().clone().startOf("month").format("YYYY-MM-DD"),
      endDate: moment().clone().endOf("month").format("YYYY-MM-DD"),
    });
  },
  methods: {
    dateLabel(date) {
      return moment(date, "YYYY-MM-DD").format("D");
    },
    month(date) {
      return moment(date, "YYYY-MM-DD").format("MMMM");
    },
    Checkin(time) {
      if (time == null) {
        return "EEE";
      } else {
        return moment(time, "HH:mm:ss").format("HH:mm");
      }
    },
    searchData() {
      this.$store.dispatch("berita/getAll", {
        search: this.search,
      });
    },
    // handleCurrentChange(val) {
    //   this.$store.commit("berita/setPage", val);
    //   this.$store.dispatch("berita/getAll", {});
    // },
    handleChangeFile(file, fileList) {
      this.form.banner = file.raw;
    },
    created() {
      this.currentTime = moment().format("LTS");
      setInterval(() => this.updateCurrentTime(), 1 * 1000);
    },
  },
  computed: {
    ...mapGetters("report", ["getAttendance", "getLoader"]),
    ...mapGetters("checkin", ["getCheckin", "getLoader"]),
  },
  watch: {
    // getBeritas(newValue, oldValue) {},
    // search(newValue, oldValue) {
    //   // this.$store.dispatch('berita/getAll', {
    //   //   search: newValue
    //   // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit("berita/setPage", newValue);
    //   this.$store.dispatch("berita/getAll", {});
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
