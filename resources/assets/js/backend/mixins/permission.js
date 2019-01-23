import UserMixins from 'mixins/user'
export default {
    mixins: [UserMixins],
    methods: {
        hasPermission(key) {
            return !!this.permissions[key]
        },
        isRole(Role) {
            return this.hasUserInfo && this.userInfo.roles[0].slug === Role
        }
    }
}
