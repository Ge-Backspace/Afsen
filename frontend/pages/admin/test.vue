<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">TEST</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-md-12">
          <br>
          <el-card v-loading="getLoader">
            <el-table :data="getAttendance.data" style="width: 100%" height="250">
              <el-table-column fixed prop="name" label="Name" width="150">
              </el-table-column>
            </el-table>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { config } from "../../../../global.config";
import { mapGetters } from 'vuex';

export default {
  layout: 'admin',
  data() {
    return {
      company_id: '',
    }
  },
  mounted () {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("report/getAttendance", {
      company_id: this.company_id,
      startDate: moment().clone().startOf("month").format("YYYY-MM-DD"),
      endDate: moment().clone().endOf("month").format("YYYY-MM-DD"),
    });
  },
  computed: {
    ...mapGetters('report', ['getAttendance', 'getLoader'])
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
