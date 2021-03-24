<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Attendance</h1>
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
                  <vs-th>Address</vs-th>
                  <vs-th>Checkin Time</vs-th>
                  <vs-th>Checkout Time</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getAttendances.data" :data="tr">
                  <vs-td>
                    {{ tr.address }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.checkin_time) }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.checkout_time) }}
                  </vs-td>
                </vs-tr>
              </template>

              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getAttendances.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getAttendances.total / table.max)"
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
    this.$store.dispatch("attendance/getUser", {
      user_id: this.user_id,
    });
  },
  methods: {
    searchData() {
      this.$store.dispatch("attendance/getUser", {
        search: this.search,
        user_id: this.user_id,
      });
    },
    handleCurrentChange(val) {
      this.$store.commit("attendance/setPage", val);
      this.$store.dispatch("attendance/getUser", {
        user_id: this.user_id,
      });
    },
    formatDate(date) {
      if (!date) {
        return 'No Data'
      } else {
        return moment(date).format("DD MMMM YYYY HH:mm");
      }
    },
  },
  computed: {
    ...mapGetters("attendance", ["getAttendances", "getLoader"]),
  },
  watch: {
    getCutiEs(newValue, oldValue) {
      //
    },
    search(newValue, oldValue) {
      this.$store.dispatch("attendance/getUser", {
        user_id: this.user_id,
        search: newValue,
      });
    },
    page(newValue, oldValue) {
      this.$store.commit("attendance/setPage", newValue);
      this.$store.dispatch("attendance/getUser", {
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
