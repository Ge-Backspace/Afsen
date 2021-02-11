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
          <br>
          <el-card>
            <div slot="header" class="clearfix">
              <div class="row">
                <div class="col-md-4">
                  <span class="demonstration">tanggal</span>
                  <br />
                  <el-date-picker
                    v-model="select"
                    type="monthrange"
                    range-separator="-"
                    start-placeholder="Start month"
                    end-placeholder="End month"
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
            <p style="font-weight: bold" class="text-center">{{ month(getReportAttendance.data.start_date) }}</p>
            <el-table v-loading="getLoader" :data="getReportAttendance.data.data" style="width: 100%" class="table-striped">
              <el-table-column label="Nama" width="200px">
                <template slot-scope="scope">
                  <div>
                    {{ scope.row.name }}
                  </div>
                </template>
              </el-table-column>
              <el-table-column v-for="(h, i) in getReportAttendance.data.dates" :data="h" :key="i" :label="dateLabel(h)" width="110px">
                <template slot-scope="scope">
                  <div>
                    {{ cColumn(scope.row.checkins[i]) }}
                  </div>
                </template>
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
      console.log(date)
      return moment(date, "YYYY-MM-DD").format("MMMM")
    },
    cColumn(data) {
      if (data.status_checkin == 0) {
        return 0
      } else if (data.status_checkin == 1) {
        return 1
      } else if (data.status_checkin == 2) {
        return 2
      }
      if (data.is_cuti) {
        return 3
      }
      if (data.is_weekend) {
        return 4
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
    ...mapGetters('report', ['getReportAttendance', 'getLoader']),
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
