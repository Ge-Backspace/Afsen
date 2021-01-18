<template>
    <div>
        <input @change="hello" type="text" v-model="nama">
        {{nama}}
    </div>
</template>

<script>
    export default {
        data() {
            return {
                nama: 'ada'
            }
        },
        methods: {
            hello(){
            console.log('hello, ' + this.nama);
        }
        },
        mounted () {
            console.log('hello from mounted');
        },

    }
</script>

<style lang="scss" scoped>

</style>
