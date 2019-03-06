export default {
    methods: {
        getUserInfo() {
            this.$store.dispatch('getUserInfo')
        }
    },
    mounted() {
        this.$bus.on('getUserInfo', this.getUserInfo)
    },
    destroyed() {
        this.$bus.off('getUserInfo')
    }
}
