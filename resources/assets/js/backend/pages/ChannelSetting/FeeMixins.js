export default {
    methods: {
        getFee(data) {
            return +_(data).getVal('user_fee.0.pivot.fee', data.fee)
        },
        getStatus(data) {
            return +_(data).getVal('user_fee.0.pivot.status', 0)
        },
        initData(data) {
            data = _.cloneDeep(data)
            data.fee = this.getFee(data)
            data.status = this.getStatus(data)
            return data
        }
    }
}
