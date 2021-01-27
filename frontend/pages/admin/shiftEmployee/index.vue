<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Shift Employee</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button warn style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/pdf`)">Download PDF</vs-button>
          &nbsp;
          <vs-button success style="float:right" :loading="globalLoader" gradient @click="downloadFile(`/information/download/xlsx`)">Download Excel</vs-button>
        </div>
      </div>
      <el-card v-loading="getLoader">
        <div class="row" style="margin-bottom:20px">
          <div class="col-md-3 offset-md-9">
            <el-input placeholder="Cari" v-model="search" @change="searchData()" size="mini">
              <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
          </div>
        </div>

      </el-card>
    </div>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

import { config } from "../../../global.config";

export default {
  layout: "admin",
  components: {},
  data() {
    return {
      api_url: config.baseApiUrl,
      table: {
        max: 10,
      },
      request:false,
      page: 1,
      titleDialog: 'Edit Shift Employee',
      search: '',
      company_id: '',
      isUpdate: false,
      userDialog: false,
      btnLoader: false,
      form: {

      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
  },
  methods: {

  },
  computed: {
    ...mapGetters("user", ["getUsers", "getLoader"]),
  },
  watch: {

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
