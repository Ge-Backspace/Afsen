<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Shift Employee</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <br />
          <el-card v-loading="getLoader">
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
                  <vs-th>Shift</vs-th>
                  <vs-th>Code</vs-th>
                  <vs-th>Schedule In</vs-th>
                  <vs-th>Schedule Out</vs-th>
                  <vs-th>Date</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getSE.data" :data="tr">
                  <vs-td>
                    {{ tr.shift_name }}
                  </vs-td>
                  <vs-td>
                    {{ tr.code }}
                  </vs-td>
                  <vs-td>
                    {{ tr.schedule_in }}
                  </vs-td>
                  <vs-td>
                    {{ tr.schedule_out }}
                  </vs-td>
                  <vs-td>
                    {{ formatDate(tr.date) }}
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getSE.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getSE.total / table.max)"
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
      active: 0,
      page: 1,
      search: "",
      user_id: "",
      btnLoader: false,
    };
  },
  mounted() {
    this.user_id = JSON.parse(JSON.stringify(this.$auth.user.id));
    this.$store.dispatch("shiftemployee/getUserShift", {
      user_id: this.user_id,
    });
  },
  methods: {
    searchData() {
      this.$store.dispatch("shiftemployee/getUserShift", {
        search: this.search,
        user_id: this.user_id,
      });
    },
    handleCurrentChange(val) {
      this.$store.commit("shiftemployee/setPage", val);
      this.$store.dispatch("shiftemployee/getUserShift", {
        user_id: this.user_id,
      });
    },
    formatDate(date) {
      return moment(date).format("DD MMMM YYYY");
    },
  },
  computed: {
    ...mapGetters("shiftemployee", ["getSE", "getLoader"]),
  },
  watch: {
    getSE(newValue, oldValue) {
      //
    },
    page(newValue, oldValue) {
      this.$store.commit("shiftemployee/setPage", newValue);
      this.$store.dispatch("shiftemployee/getUserShift", {
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
