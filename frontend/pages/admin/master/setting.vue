<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Setting</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <vs-row>
        <vs-col w="6" style="padding:20px">
          <el-card>
            <div slot="header" class="clearfix">
              <!-- Title -->
              <h5 class="h3 mb-0">Pelaksana Kegiatan</h5>
            </div>
            <vs-table v-model="data" striped>
              <template #thead>
                <vs-tr>
                  <vs-th>Setting</vs-th>
                   <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>

              </template>
              <template #footer>
                <vs-pagination style="margin:10px !important" v-model="table.page" :length="10" />
              </template>
            </vs-table>
          </el-card>
        </vs-col>
      </vs-row>
    </div>
  </div>
</template>

<script>
  export default {
    layout: 'admin',
    components: {

    },
    data() {
        return {
            data: [],
            table: {
                page: 1,
                max: 10
            }
        }
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
