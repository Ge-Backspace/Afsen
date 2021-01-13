<template>
    <div>
        <p>{{ $store.state.company.company.name }}</p>
    </div>
</template>

<script>
    export default {
        mounted () {
          console.log(this.$store.state.company.company);
        },
    }
</script>

<style lang="scss" scoped>

</style>
