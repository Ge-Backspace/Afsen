<template>
   <div>
     <el-table :data="tableData" style="width: 100%" height="250">
      <el-table-column fixed prop="name" label="Employee" width="150"></el-table-column>
      <el-table-column prop="zip" :label="col.date" v-for="col in dates" :key="col.id"></el-table-column>
    </el-table>
   </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  export default {
      data() {
          return {
            company_id: '',
            table: {
              max: 10
            },
            lastDay: '',
            dates:[]
          }
      },
      methods: {
        formatTime(time){
          return moment(String(time)).format('dddd, DDD MMMM YYYY hh:mm');
        }
      },
      mounted () {
        this.lastDay = Number(moment().clone().endOf('month').format('DD'))
        console.log(this.lastDay)
        for (let i = 0; i <= this.lastDay; i++) {
          this.dates.push({
            date: i
          })
        }
      },
      computed: {
      },
      created () {
      },
  }
</script>

<style lang="scss" scoped>

</style>
