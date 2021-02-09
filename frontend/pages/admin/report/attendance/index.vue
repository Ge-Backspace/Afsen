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
          <el-card v-loading="getLoader">
            <div slot="header" class="clearfix">
              <div class="row">
                <div class="col-md-4">
                  <span class="demonstration">tanggal</span>
                  <br />
                  <el-date-picker
                    v-model="value1"
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
            <p style="font-weight: bold" class="text-center">{{ $moment(Date.now()).format("MMMM")}}</p>

            <el-table :data="tableData" style="width: 100%" height="250">
              
              <el-table-column fixed prop="name" label="Name" width="150">
              </el-table-column>
              <el-table-column
                prop="presence"
                :label="col.tanggal"
                v-for="col in data"
                :key="col.id"
              ></el-table-column>
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
      tableData: [{
        name: 'kafabih',
        presence: 'test',
        }],
      data: [],
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.lastDate = Number(moment().clone().endOf("month").format("DD"));
    console.log(this.lastDate);
    for (let i = 0; i <= this.lastDate; i++) {
      this.data.push({
        tanggal: i,
      });
    }
    
    this.$store.dispatch("report/getAttendance", {
      company_id: this.company_id,
      startDate: moment().clone().startOf("month").format("YYYY-MM-DD"),
      endDate: moment().clone().endOf("month").format("YYYY-MM-DD"),
    });
    let now = moment(this.currentTime, "HH:mm:ss A").format("HH:mm:ss");
  },
  methods: {
    searchData() {
      this.$store.dispatch("berita/getAll", {
        search: this.search,
      });
    },
    resetForm() {
      this.form = {
        judul: "",
        banner: null,
        aktif: true,
        deskripsi: "",
      };
      this.files = [];
      this.isUpdate = false;
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
