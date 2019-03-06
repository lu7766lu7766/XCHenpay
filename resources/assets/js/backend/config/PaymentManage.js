import PaymentConConfig from 'config/PaymentConnConfig'

class PaymentManage {
    static ALI_PAY = 'aliPay'

    static WE_CHAT_PAY = 'weChatPay'

    static UNION_PAY = 'unionPay'

    static QQ_PAY = 'qqPay'

    static ALI_PAY_TXT = '支付宝'

    static WE_CHAT_PAY_TXT = '微信'

    static UNION_PAY_TXT = '银联卡'

    static QQ_PAY_TXT = 'QQ钱包'

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
