<template>
    <report/>
</template>

<script>
    export default {
        api: "reportStatistics",
        components: {
            Report: require('./index')
        }
    }
</script>
