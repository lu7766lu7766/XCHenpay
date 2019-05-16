import PaymentConConfig from 'config/PaymentConnConfig'

class PaymentManage {
    static ALI_PAY = 'aliPay'

    static WE_CHAT_PAY = 'weChatPay'

    static UNION_PAY = 'unionPay'

    static QQ_PAY = 'qqPay'

    static ALI_PAY_RED_ENVELOP = 'aliPayRedEnvelop'

    static ALI_PAY_PERSONAL_BANK_ACCOUNT = 'aliPayPersonalBankAccount'

    static WE_CHAT_PAYEE_QRCODE = 'weChatPayeeQRCode'

    static QUICK_PASS_PAYEE_QRCODE = 'QuickPassPayeeQRCode'

    static ALI_PAY_PERSON_PAYEE = 'aliPayPersonPayee'

    static ALI_PAY_TRANSFER_OUT = 'aliPayTransferOut'

    static ALI_PAY_TXT = '支付宝'

    static WE_CHAT_PAY_TXT = '微信'

    static UNION_PAY_TXT = '银联卡'

    static QQ_PAY_TXT = 'QQ钱包'

    static ALI_PAY_RED_ENVELOP_TXT = '支付宝红包'

    static ALI_PAY_PERSONAL_BANK_ACCOUNT_TXT = '支付宝收款(固码)'

    static WE_CHAT_PAYEE_QRCODE_TXT = '微信收款(固码)'

    static QUICK_PASS_PAYEE_QRCODE_TXT = '云闪付收款(固码)'

    static ALI_PAY_PERSON_PAYEE_TXT = '支付宝转支付宝'

    static ALI_PAY_TRANSFER_OUT_TXT = '支付宝转帐'

    static enum() {
        return [
            this.ALI_PAY,
            this.WE_CHAT_PAY,
            this.UNION_PAY,
            this.QQ_PAY,
            this.ALI_PAY_RED_ENVELOP,
            this.ALI_PAY_PERSONAL_BANK_ACCOUNT,
            this.WE_CHAT_PAYEE_QRCODE,
            this.QUICK_PASS_PAYEE_QRCODE,
            this.ALI_PAY_PERSON_PAYEE,
            this.ALI_PAY_TRANSFER_OUT
        ]
    }

    static summaryMap() {
        return {
            [this.ALI_PAY]: this.ALI_PAY_TXT,
            [this.WE_CHAT_PAY]: this.WE_CHAT_PAY_TXT,
            [this.UNION_PAY]: this.UNION_PAY_TXT,
            [this.QQ_PAY]: this.QQ_PAY_TXT,
            [this.ALI_PAY_RED_ENVELOP]: this.ALI_PAY_RED_ENVELOP_TXT,
            [this.ALI_PAY_PERSONAL_BANK_ACCOUNT]: this.ALI_PAY_PERSONAL_BANK_ACCOUNT_TXT,
            [this.WE_CHAT_PAYEE_QRCODE]: this.WE_CHAT_PAYEE_QRCODE_TXT,
            [this.QUICK_PASS_PAYEE_QRCODE]: this.QUICK_PASS_PAYEE_QRCODE_TXT,
            [this.ALI_PAY_PERSON_PAYEE]: this.ALI_PAY_PERSON_PAYEE_TXT,
            [this.ALI_PAY_TRANSFER_OUT]: this.ALI_PAY_TRANSFER_OUT_TXT
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
            case this.ALI_PAY_RED_ENVELOP:
            case this.ALI_PAY_PERSON_PAYEE:
            case this.ALI_PAY_TRANSFER_OUT:
                res[PaymentConConfig.ALI_PAY_ACCOUNT] = true
                res[PaymentConConfig.PID] = true
                break
            case this.ALI_PAY_PERSONAL_BANK_ACCOUNT:
                res[PaymentConConfig.ALI_PAY_ACCOUNT] = true
                res[PaymentConConfig.QRCODE_URL] = true
                res[PaymentConConfig.QRCODE_URL_TIME] = true
                break
            case this.WE_CHAT_PAYEE_QRCODE:
            case this.QUICK_PASS_PAYEE_QRCODE:
                res[PaymentConConfig.ACCOUNT] = true
                res[PaymentConConfig.QRCODE_URL] = true
                res[PaymentConConfig.QRCODE_URL_TIME] = true
                break
        }
        return res
    }
}

export {PaymentManage as default}
