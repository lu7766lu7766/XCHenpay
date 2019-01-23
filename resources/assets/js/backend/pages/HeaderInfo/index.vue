<template>
    <span>
        <info/>
        <notify/>
    </span>
</template>

<script>
    export default {
        api: "outer",
        components: {
            Info: require('./Info'),
            Notify: require('./Notify')
        }
    }
</script>
