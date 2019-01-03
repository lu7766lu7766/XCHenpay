export default {
    methods: {
        hasPermission(key) {
            return !!this.$root.permissions[key]
        }
    }
}
