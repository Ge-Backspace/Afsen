<template>
   <div>
     <vs-table striped>
          <template #thead>
            <vs-tr>
              <vs-th>Name</vs-th>
              <vs-th>Checkin Time</vs-th>
              <vs-th>Checkout Time</vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr :key="i" v-for="(tr, i) in getCheckin.data" :data="tr">
              <vs-td>
                {{ tr.name }}
              </vs-td>
              <vs-td>
                {{ formatTime(tr.checkin_time) }}
              </vs-td>
              <vs-td>
                {{ formatTime(tr.checkout_time) }}
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
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
          }
      },
      methods: {
        formatTime(time){
          return moment(String(time)).format('dddd, DDD MMMM YYYY hh:mm');
        }
      },
      mounted () {
        this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
        this.$store.dispatch('checkin/getAll', {
          showall: 1,
          company_id: this.company_id
        });
      },
      computed: {
        ...mapGetters("checkin", [
          'getCheckin',
          // 'getLoader',
          // 'getSummary'
        ]),
      },
      created () {
      },
  }
</script>

<style lang="scss" scoped>

</style>
