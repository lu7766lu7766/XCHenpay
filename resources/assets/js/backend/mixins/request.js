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
        validate() {
            let message = ''
            _.forEach(this.$options.rules, (rules, variable) => {
                var getRealVar = varStr => _.reduce(varStr.split('.'), (result, key) => {
                    return result[key]
                }, this)
                let realVar = getRealVar(variable)
                var proccessValidate = (res, msg) => message += res ? `${msg}\n` : ''
                _.forEach(rules, (rule, ruleName) => {
                    switch (ruleName) {
                        case 'require':
                            // console.log(variable, realVar, _.isNull(realVar) || _.isUndefined(realVar) || realVar === '')
                            proccessValidate(_.isNull(realVar) || _.isUndefined(realVar) || realVar === '', rule.message)
                            break
                        case 'type':
                            proccessValidate(typeof realVar !== rule.value, rule.message)
                            break
                        case 'number':
                            proccessValidate(isNaN(parseInt(realVar)), rule.message)
                            break
                        case 'min':
                            proccessValidate(realVar < rule.value, rule.message)
                            break
                        case 'max':
                            proccessValidate(realVar > rule.value, rule.message)
                            break
                        case 'email':
                            proccessValidate(!(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i).test(realVar), rule.message)
                            break
                        case 'equal':
                            proccessValidate(getRealVar(rule.value) !== realVar, rule.message)
                            break
                        case 'ips':
                            const pattern = /^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/;
                            const isIP = val => pattern.test(val)
                            let isPass = true
                            realVar.split(',').forEach(val => {
                                if (!isIP(val)) {
                                    isPass = false
                                    return
                                }
                            })
                            proccessValidate(!isPass, rule.message)
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
