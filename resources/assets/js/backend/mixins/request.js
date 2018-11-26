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
        },
        async proccessAjax(target, data, cb) {
            let loader = this.$loading.show({
                container: this.$el,
            })
            this.data = {}
            var res = await this.$callApi(`${this.apiKey}:${target}`, this.createReqBody(data), loader)
            cb(res)
            loader.hide()
        },
        createReqBody(data) {
            return this.convertMoment2String(_.assign({}, data))
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
