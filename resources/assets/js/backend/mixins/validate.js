var isNum = val => !isNaN(parseInt(val))

export default {
    methods: {
        // 取得實際變數值
        getRealVar(varStr) {
            return _.reduce(varStr.split('.'), (result, key) => {
                return result[key]
            }, this)
        },
        validate() {
            let message = ''
            _.forEach(this.$options.rules, (rules, variable) => {
                // 是否持續驗證
                let doValidate = true
                let realVar = this.getRealVar(variable)

                // 驗證方法
                var proccessValidate = (res, msg) => message += res ? `${msg}\n` : ''

                // sometimes優先判斷
                if (!_.isUndefined(rules.sometimes)) {
                    if (_.isNull(realVar) || _.isUndefined(realVar) || realVar === '') {
                        // 不做後續驗證
                        doValidate = false
                    }
                }

                _.forEach(rules, (rule, ruleName) => {
                    // 不做驗證
                    if (!doValidate) return false
                    switch (ruleName) {
                        case 'require':
                            // console.log(variable, realVar, _.isNull(realVar) || _.isUndefined(realVar) || realVar === '')
                            proccessValidate(_.isNull(realVar) || _.isUndefined(realVar) || realVar === '', rule.message)
                            break
                        case 'type':
                            proccessValidate(typeof realVar !== rule.value, rule.message)
                            break
                        case 'number':
                            proccessValidate(!isNum(realVar), rule.message)
                            break
                        case 'integer':
                            proccessValidate(realVar !== parseInt(realVar, 10), rule.message)
                            break
                        case 'min':
                            if (typeof realVar == 'number' || isNum(realVar)) {
                                if (typeof rule.value == 'string') {
                                    proccessValidate(realVar < this.getRealVar(rule.value), rule.message)
                                } else if (typeof rule.value == 'number') {
                                    proccessValidate(realVar < rule.value, rule.message)
                                }
                            } else if (typeof realVar == 'string') {
                                proccessValidate(realVar.length < rule.value, rule.message)
                            } else if (typeof realVar == 'object') {
                                proccessValidate(Object.keys(realVar).length < rule.value, rule.message)
                            }
                            break
                        case 'max':
                            if (typeof realVar == 'number' || isNum(realVar)) {
                                if (typeof rule.value == 'string') {
                                    proccessValidate(realVar > this.getRealVar(rule.value), rule.message)
                                } else if (typeof rule.value == 'number') {
                                    proccessValidate(realVar > rule.value, rule.message)
                                }
                            } else if (typeof realVar == 'string') {
                                proccessValidate(realVar.length > rule.value, rule.message)
                            } else if (typeof realVar == 'object') {
                                proccessValidate(Object.keys(realVar).length > rule.value, rule.message)
                            }
                            break
                        case 'email':
                            proccessValidate(!(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i).test(realVar), rule.message)
                            break
                        case 'equal':
                            proccessValidate(this.getRealVar(rule.value) != realVar, rule.message)
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
                        case 'alpha_dash':
                            proccessValidate(/[^\w\-\_]/.test(realVar), rule.message)
                            break
                    }
                })
            })
            if (message) throw message
        }
    }
}
