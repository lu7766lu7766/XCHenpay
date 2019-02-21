import PaymentConConfig from 'config/PaymentConnConfig'

class PaymentManage {
    static get ALI_PAY() {
        return 'aliPay'
    }

    static get WE_CHAT_PAY() {
        return 'weChatPay'
    }

    static get UNION_PAY() {
        return 'unionPay'
    }

    static get QQ_PAY() {
        return 'qqPay'
    }

    static get ALI_PAY_TXT() {
        return '支付宝'
    }

    static get WE_CHAT_PAY_TXT() {
        return '微信'
    }

    static get UNION_PAY_TXT() {
        return '银联卡'
    }

    static get QQ_PAY_TXT() {
        return 'QQ钱包'
    }

    static enum() {
        return [
            this.ALI_PAY,
            this.WE_CHAT_PAY,
            this.UNION_PAY,
            this.QQ_PAY
        ]
    }

    static summaryMap() {
        return {
            [this.ALI_PAY]: this.ALI_PAY_TXT,
            [this.WE_CHAT_PAY]: this.WE_CHAT_PAY_TXT,
            [this.UNION_PAY]: this.UNION_PAY_TXT,
            [this.QQ_PAY]: this.QQ_PAY_TXT
        }
    }

    static getCurrentConnKey(type) {
        let res = {}
        switch (type) {
            case this.ALI_PAY :
                res[PaymentConConfig.APP_ID] = true
                res[PaymentConConfig.APP_PUBLIC_KEY] = true
                res[PaymentConConfig.PRIVATE_KEY] = true
                break
            case this.WE_CHAT_PAY :
                res[PaymentConConfig.APP_ID] = true
                res[PaymentConConfig.MCH_ID] = true
                res[PaymentConConfig.PRIVATE_KEY] = true
                break
            case this.UNION_PAY :
                res[PaymentConConfig.MCH_ID] = true
                res[PaymentConConfig.CERT_PWD] = true
                res[PaymentConConfig.CERT_PATH] = true
                res[PaymentConConfig.APP_URL] = true
                break
            case this.QQ_PAY :
                res[PaymentConConfig.MCH_ID] = true
                res[PaymentConConfig.PRIVATE_KEY] = true
                res[PaymentConConfig.CERT_PATH] = true
                break
        }
        return res
    }
}

export {PaymentManage as default}
