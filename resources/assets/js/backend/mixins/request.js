import ValidMixins from 'mixins/validate'

export default {
    mixins: [ValidMixins],
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
        async proccessAjax(target, data = {}, cb, isLoading = true) {
            let loader = isLoading ? this.$loading.show({
                container: this.$el,
            }) : null
            var res = await this.$callApi(`${this.apiKey}:${target}`, this.createReqBody(data), loader)
            if (cb) cb(res)
            loader && loader.hide()
            return res
        },
        createReqBody(data) {
            return this.convertMoment2String(_.cloneDeep(data))
        },
        conbineRules(rules) {
            _.mergeWith(this.$options.rules, rules, (oValue, nValue) => {
                return _.assign(oValue, nValue);
            })
        },
        // new api
        async callApi(f) {
            let loader = this.$loading.show({
                container: this.$el,
            })
            try {
                await f()
            } catch (e) {
                loader.hide()
                throw e
            }
            loader.hide()
        }
    },
    computed: {
        apiKey() {
            let res = this.$options.api ? [this.$options.api] : [], $parent = this.$parent
            while ($parent && $parent.$options.api) {
                res.push($parent.$options.api)
                $parent = $parent.$parent
            }
            return _.reverse(res).join(':')
        },
    }
}
