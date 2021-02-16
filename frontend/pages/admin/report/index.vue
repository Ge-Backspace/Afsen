<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Kagiatan</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <el-card v-loading="getLoader" class="col-xl-3">
          <router-link to="/admin/report/attendance">
            <vs-card>
              <template #title>
                <h3>Attendances</h3>
              </template>
              <template #img>
                <img src="../../../assets/img/icons/pencil.png" alt="" />
              </template>
              <template #text>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
              </template>
            </vs-card>
          </router-link>
        </el-card>
        <el-card v-loading="getLoader" class="col-xl-3">
          <router-link to="">
            <vs-card>
              <template #title>
                <h3>Salary</h3>
              </template>
              <template #img>
                <img src="../../../assets/img/icons/money.png" alt="" />
              </template>
              <template #text>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
              </template>
            </vs-card>
          </router-link>
        </el-card>
        <el-card v-loading="getLoader" class="col-xl-3">
          <router-link to="">
            <vs-card>
              <template #title>
                <h3>Permission</h3>
              </template>
              <template #img>
                <img src="../../../assets/img/icons/permission.png" alt="" />
              </template>
              <template #text>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
              </template>
            </vs-card>
          </router-link>
        </el-card>
        <el-card v-loading="getLoader" class="col-xl-3">
          <router-link to="">
            <vs-card>
              <template #title>
                <h3>Employee</h3>
              </template>
              <template #img>
                <img src="../../../assets/img/icons/employee.png" alt="" />
              </template>
              <template #text>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
              </template>
            </vs-card>
          </router-link>
        </el-card>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "admin",
  components: {},
  data() {
    return {
      api_url: "",
      headers: {
        // 'Authorization': 'Bearer ' + this.$axios.g
      },
      table: {
        max: 10,
      },
      page: 1,
    };
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
