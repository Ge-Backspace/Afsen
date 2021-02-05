<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Calendar</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card>
            <div class="row">
              <div class="col-8">
                <el-calendar v-model="date">
                  <template
                    slot="dateCell"
                    slot-scope="{date, data}">
                    <el-button v-on:click="clickDate(data)">
                      {{day(date)}}
                    </el-button>
                  </template>
                </el-calendar>
              </div>
              <div class="col-4 card text-white bg-primary mb-3" v-loading="getLoader">
                <div class="card-head text-center" style="margin-top: 20px">{{ dates(date) }}</div>
                <div class="card-body">
                  <h5 class="card-title"></h5>
                    <p class="card-text">Shift :</p>
                    <div v-for="c in getSE.data" :key="c.id">
                      <p class="card-text">
                        - {{ c.name }} : {{c.code}} {{c.schedule_in}}-{{c.schedule_out}}
                      </p>
                    </div>
                </div>
              </div>
            </div>
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
      active: '',
      company_id: null,
      date: new Date(),
      data: {
        isSelected: '',
      }
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id))
    this.$store.dispatch('shiftemployee/getAll', {
      company_id: this.company_id,
      search: new Date()
    })
  },
  methods: {
    // handleCurrentChange(val) {
    //   this.$store.commit("goverment/setPage", val);
    //   this.$store.dispatch("goverment/getAll", {});
    // },
    day(date) {
      return moment(date).format('DD')
    },
    dates(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    clickDate(date) {
      this.$store.dispatch('shiftemployee/getAll', {
        company_id: this.company_id,
        search: date.day
      })
    },
  },
  computed: {
    ...mapGetters('shiftemployee', ['getSE', 'getLoader']),
  },
  watch: {
    // getGoverments(newValue, oldValue) {},
    // search(newValue, oldValue) {
      // this.$store.dispatch('goverment/getAll', {
      //   search: newValue
      // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit("goverment/setPage", newValue);
    //   this.$store.dispatch("goverment/getAll", {});
    // },
  },
};
</script>

<style lang="scss" scoped>
.heading {
  color: white;
  font-size: 25px;
  font-weight: bold;
.is-selected {
  color: #1989FA;
}
}
</style>
