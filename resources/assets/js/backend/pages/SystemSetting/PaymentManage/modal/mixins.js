const commonRules = {
    'data.name': {
        require: {
            message: '名称 不得为空白'
        }
    },
    'data.min_deposit': {
        require: {
            message: '最低储值 不得为空白'
        },
        number: {
            message: '最低储值 请输入数字'
        }
    },
    'data.max_deposit': {
        require: {
            message: '最高储值 不得为空白'
        },
        number: {
            message: '最高储值 请输入数字'
        }
    },
    'data.total_deposit': {
        require: {
            message: '总储值金额 不得为空白'
        },
        number: {
            message: '总储值金额 请输入数字'
        }
    },
    'data.withdraw': {
        require: {
            message: '提领金额 不得为空白'
        },
        number: {
            message: '提领金额 请输入数字'
        }
    },
    'data.vendor': {
        require: {
            message: '金流来源 不得为空白'
        }
    }
}

export default {
    methods: {
        onVendorChanged() {
            this.$options.rules = _.cloneDeep(commonRules)
            this.data.conn_config = _.reduce(this.connKeys, (result, key) => {
                result[key] = ''
                this.$options.rules[`data.conn_config.${key}`] = {
                    require: {
                        message: this.$parent.config.PaymentConnConfigSummary[key] + ' 不得为空白'
                    }
                }
                return result
            }, {})
        }
    },
    computed: {
        user_id() {
            return this.$root.userInfo ? this.$root.userInfo.id : ''
        },
        connKeys() {
            return _.keys(this.$parent.config.PaymentManage.getCurrentConnKey(this.data.vendor))
        }
    },
    mounted() {
        this.onVendorChanged()
    }
}
