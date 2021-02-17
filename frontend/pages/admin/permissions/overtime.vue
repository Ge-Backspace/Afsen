<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <h1 class="heading">Overtime</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
          <vs-button
            warn
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="exportData('pdf')"
            >Download PDF</vs-button
          >
          &nbsp;
          <vs-button
            success
            style="float: right"
            :loading="globalLoader"
            gradient
            @click="exportData('excel')"
            >Download Excel</vs-button
          >
          <el-card v-loading="getLoader" style="margin-top: 100px">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-2">
                <vs-button
                  success
                  style="float: right"
                  :loading="globalLoader"
                  gradient
                  @click="
                    importDialog = true;
                    titleDialog = 'Import Shift Employee';
                  "
                  >Import Excel</vs-button
                >
              </div>
              <div class="col-md-3 offset-md-7">
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
                  <vs-th>Employee</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getOverTime.data" :data="tr">
                  <vs-td>{{ tr.name }}</vs-td>
                </vs-tr>
              </template>
              <!-- <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getOverTime.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getOverTime.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template> -->
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
    layout: "admin",
    components: {},
    data() {
      return {
        api_url: config.baseApiUrl,
        company_id: 0,
        active: 0,
        search: '',
        page: 1,
        table: {
          max: 10,
        },
      }
    },
    mounted () {
      this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id))
      this.$store.dispatch("overtime/getAll", {
        company_id: this.company_id,
      });
    },
    methods: {
      exporData(type) {
        //
      },
      searchData() {
      this.$store.dispatch("shiftemployee/getAll", {
          search: this.search,
          company_id: this.company_id,
        })
      },

    },
    computed: {
      ...mapGetters("overtime", ["getOverTime", "getLoader"]),
    },
    watch: {
      // getOverTime(newValue, oldValue) {
      //   this.$store.dispatch("overtime/getAll", {
      //     company_id: this.company_id
      //   })
      // },
      search(newValue, oldValue) {
        this.$store.dispatch("overtime/getAll", {
          company_id: this.company_id,
          search: newValue
        });
      },
      page(newValue, oldValue) {
        this.$store.commit("overtime/setPage", newValue);
        this.$store.dispatch("overtime/getAll", {
          company_id: this.company_id,
        });
      },
    },

  }
</script>

<style lang="scss" scoped>
.heading {
  color: white;
  font-size: 25px;
  font-weight: bold;
}
</style>
