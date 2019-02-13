export default {
    methods: {
        hasCustom(data) {
            return data.user_fee && data.user_fee[0]
        },
        getFee(data) {
            return this.hasCustom(data)
                ? data.user_fee[0].pivot.fee
                : data.fee
        },
        getStatus(data) {
            return this.hasCustom(data)
                ? +data.user_fee[0].pivot.status
                : data.activate
        },
        initData(data) {
            data = _.cloneDeep(data)
            data.fee = this.getFee(data)
            data.status = this.getStatus(data)
            return data
        }
    }
}
