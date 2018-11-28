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
        async proccessAjax(target, data = {}, cb) {
            let loader = this.$loading.show({
                container: this.$el,
            })
            this.data = {}
            var res = await this.$callApi(`${this.apiKey}:${target}`, this.createReqBody(data), loader)
            if (cb) cb(res)
            loader.hide()
            return res
        },
        createReqBody(data) {
            return this.convertMoment2String(_.assign({}, data))
        },
        validate() {
            let message = ''
            _.forEach(this.$options.rules, (rules, variable) => {
                let realVar = this
                _.forEach(variable.split('.'), key => {
                    try {
                        realVar = realVar[key]
                    } catch (e) {
                        console.log(e)
                    }
                })
                var proccessValidate = (res, msg) => message += res ? `${msg}\n` : ''
                _.forEach(rules, (rule, ruleName) => {
                    switch (ruleName) {
                        case 'require':
                            proccessValidate(rule.value && !realVar, rule.message)
                            break
                        case 'type':
                            proccessValidate(typeof realVar !== rule.value, rule.message)
                            break
                        case 'min':
                            proccessValidate(realVar < rule.value, rule.message)
                            break
                        case 'max':
                            proccessValidate(realVar > rule.value, rule.message)
                            break
                    }
                })
            })
            if (message) throw message
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
