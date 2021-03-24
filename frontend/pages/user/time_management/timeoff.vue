<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Time Off</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card v-loading="getLoader" style="margin-top: 40px">
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
                  <vs-th>Nama Cuti</vs-th>
                  <vs-th>Code Cuti</vs-th>
                  <vs-th>Start Date</vs-th>
                  <vs-th>Expired Date</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getCutiEs.data" :data="tr">
                  <vs-td>
                    {{ tr.cuti_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.code }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.start_date) }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.expired_date) }}
                  </vs-td>
                  <template #expand>
                    <vs-row>
                      <div class="con-content">
                        <h1>Reason</h1>
                        <div v-html="tr.reason">
                          {{ tr.reason }}
                        </div>
                      </div>
                      <div >
                        <vs-button
                          success
                          style="float: right; margin-left: 50px;"
                          :loading="globalLoader"
                          gradient
                          @click="exportData('excel')"
                          >Evidence</vs-button
                        >
                      </div>
                    </vs-row>
                  </template>
                </vs-tr>
              </template>

              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getCutiEs.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getCutiEs.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

import { config } from "../../../global.config";

export default {
  layout: "user",
  components: {},
  data() {
    return {
      api_url: config.baseApiUrl,
      table: {
        max: 10,
      },
      request: false,
      active: 0,
      page: 1,
      search: "",
      user_id: "",
      btnLoader: false,
    };
  },
  mounted() {
    this.user_id = JSON.parse(JSON.stringify(this.$auth.user.id));
    this.$store.dispatch("cutiemployee/getUser", {
      user_id: this.user_id,
    });
  },
  methods: {
    searchData() {
      this.$store.dispatch("cutiemployee/getUser", {
        search: this.search,
        user_id: this.user_id,
      });
    },
    handleCurrentChange(val) {
      this.$store.commit("cutiemployee/setPage", val);
      this.$store.dispatch("cutiemployee/getUser", {
        user_id: this.user_id,
      });
    },
    formatDate(date) {
      return moment(date).format("DD MMMM YYYY");
    },
  },
  computed: {
    ...mapGetters("cutiemployee", ["getCutiEs", "getLoader"]),
  },
  watch: {
    getCutiEs(newValue, oldValue) {
      //
    },
    search(newValue, oldValue) {
      this.$store.dispatch("cutiemployee/getUser", {
        user_id: this.user_id,
        search: newValue,
      });
    },
    page(newValue, oldValue) {
      this.$store.commit("cutiemployee/setPage", newValue);
      this.$store.dispatch("cutiemployee/getUser", {
        user_id: this.user_id,
      });
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
