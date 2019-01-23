export default {
    methods: {
        async getUserInfo() {
            await this.$store.dispatch('getUserInfo')
            this.$bus.emit('userInfo.init')
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo
        },
        hasUserInfo() {
            return this.userInfo.roles && this.userInfo.roles[0]
        },
        permissions() {
            return this.hasUserInfo
                ? this.userInfo.roles[0].permissions
                : {}
        }
    },
    mounted() {
        this.$bus.on('getUserInfo', this.getUserInfo)
    },
    destroyed() {
        this.$bus.off('getUserInfo')
    }
}
