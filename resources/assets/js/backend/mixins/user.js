export default {
    data: {
        userInfo: {}
    },
    methods: {
        async getUserInfo() {
            const res = await this.$callApi('userInfo')
            this.userInfo = res.data
            this.$root.$emit('userInfo.init')
        }
    },
    computed: {
        permissions() {
            return this.userInfo.roles && this.userInfo.roles[0]
                ? this.userInfo.roles[0].permissions
                : {}
        }
    },
    mounted() {
        this.$root.$on('getUserInfo', this.getUserInfo)
        this.getUserInfo()
    },
    destroyed() {
        this.$root.$off('getUserInfo')
    }
}
