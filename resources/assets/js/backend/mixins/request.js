export default {
    data: () => ({
        reqDateFormat: 'YYYY-MM-DD HH:mm:ss'
    }),
    methods: {
        convertMoment2String(res) {
            _.forEach(res, (val, key) => {
                if (moment.isMoment(val)) {
                    res[key] = val.format(this.reqDateFormat)
                }
            })
            return res
        }
    },
    computed: {
        apiKey() {
            let res = this.$options.api ? [this.$options.api] : [], $parent = this.$parent
            while ($parent.$options.api) {
                res.push($parent.$options.api)
                $parent = $parent.$parent
            }
            return _.reverse(res).join(':')
        },
    }
}
