import QrCode from 'qrcode-reader'

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
                const message = (typeof this.$parent.config.PaymentConnConfigSummary[key] == 'object'
                    ? this.$parent.config.PaymentConnConfigSummary[key][this.data.vendor]
                    : this.$parent.config.PaymentConnConfigSummary[key]) + ' 不得为空白'
                this.$options.rules[`data.conn_config.${key}`] = {
                    require: {
                        message
                    }
                }
                return result
            }, {})
        },
        async imgHandler(e, key, timeKey) {
            try {
                const url = await this.getQrcodeUrl(e.target.files[0])
                this.data.conn_config[key] = url
                this.data.conn_config[timeKey] = moment().format('YYYY-MM-DD HH:mm:ss')
                e.target.value = ''
            } catch (e) {
                alert('无法解析此图片')
            }
        },
        getQrcodeUrl(file) {
            return new Promise((resolve, reject) => {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    const qr = new QrCode()
                    qr.callback = (err, value) => {
                        if (err) {
                            reject(err)
                            return
                        }
                        resolve(value.result)
                    };
                    qr.decode(reader.result)
                };
                reader.onerror = function (error) {
                    reject(error)
                };
            })
        }
    },
    computed: {
        connKeys() {
            return _.keys(this.$parent.config.PaymentManage.getCurrentConnKey(this.data.vendor))
        }
    },
    mounted() {
        this.onVendorChanged()
    }
}
