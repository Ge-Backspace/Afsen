<template>
  <div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <el-card style="margin-top: 80px">
            <div class="row">
              <div class="col-md-6">
                  <h2 style="text-align: center">Statistic Company</h2>
                  <ChartLine />
              </div>
              <div class="col-md-6">
                <h2 style="text-align: center">New Company</h2>
                <vs-table striped>
                  <template #thead>
                    <vs-tr>
                      <vs-th>Name</vs-th>
                      <vs-th>Date</vs-th>
                    </vs-tr>
                  </template>
                  <template #tbody>
                    <vs-tr :key="i" v-for="(tr, i) in getCompany.data.data" :data="tr">
                      <vs-td>
                        {{ tr.name }}
                      </vs-td>
                      <vs-td>
                        {{ formatDate(tr.created_at) }}
                      </vs-td>
                    </vs-tr>
                  </template>
                </vs-table>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ChartLine from "@/components/chart/chart-line";
  import {mapMutations, mapGetters} from 'vuex';
  import moment from 'moment';

  export default {
    components: {
      ChartLine
    },
    layout: "superadmin",
    mounted () {
      this.$store.dispatch('company/getNewCompany',{
        //
      })
    },
    methods: {
      formatDate(date) {
        return moment(date).format("DD MMMM YYYY")
      }
    },
    computed: {
      ...mapGetters('company', ['getCompany', 'getLoader'])
    },
  }
</script>

<style lang="scss" scoped>

</style>
