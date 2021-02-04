<template>
    <div>
      <h1>Checkin : {{ cin }}</h1>
      <h1>Checkout : {{ cout }}</h1>
      <h1>Schedule in : {{ scin }}</h1>
      <h1>Schedule out : {{ scout }}</h1>
      <h1>Jam Kerja : {{ timeFormat(coutcin) }}</h1>
      <h1>Jam Telat : {{ timeFormat(cinscin) }}</h1>
      <h1>Jam Lembur : {{ timeFormat(coutscout) }}</h1>
      <h1>Diff : {{ timeFormat(diff) }}</h1>
      <!-- <h1>Gaji Perjam : {{ ignoreDot(gpjam) }}</h1> -->
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        data() {
            return {
                cin: '09:00:00',
                cout: '19:00:00',
                scin: '08:00:00',
                scout: '16:00:00',
                coutcin: '',
                cinscin: '',
                coutscout: '',
                diff: '',
                gpokok: '5000000',
                gpjam: '',
                g: ''
            }
        },
        mounted () {
            this.coutcin = moment.utc(moment(this.cout, 'HH:mm:ss').diff(moment(this.cin, 'HH:mm:ss')))
            this.cinscin = moment.utc(moment(this.cin, 'HH:mm:ss').diff(moment(this.scin, 'HH:mm:ss')))
            this.coutscout = moment.utc(moment(this.cout, 'HH:mm:ss').diff(moment(this.scout, 'HH:mm:ss')))
            this.diff = moment.utc(moment(this.coutcin).diff(moment(this.cinscin)))
            this.diff = moment.utc(moment(this.diff).diff(moment(this.coutscout)))
            this.gpjam = 1 / 173 * this.gpokok
            this.gpjam = Math.floor(this.gpjam)
            let jk = Number(moment(this.diff).format('HH'))
            this.g = this.gpjam * jk
            console.log([this.gpokok, this.gpjam, jk, this.g])
        },
        methods: {
          timeFormat(time) {
            return moment(time).format('HH:mm:ss')
          },
        },
    }
</script>

<style lang="scss" scoped>

</style>
