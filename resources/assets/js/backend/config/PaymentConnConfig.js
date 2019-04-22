import PaymentManage from 'config/PaymentManage'

class PaymentConnConfig {
    static APP_ID = 'app_id'

    static APP_ID_TXT = '应用ID'

    static APP_PUBLIC_KEY = 'app_public_key'

    static APP_PUBLIC_KEY_TXT = '公钥'

    static PRIVATE_KEY = 'private_key'

    static PRIVATE_KEY_TXT = '私钥'

    static MCH_ID = 'mch_id'

    static MCH_ID_TXT = '商户ID'

    static CERT_PWD = 'cert_pwd'

    static CERT_PWD_TXT = '证书密码'

    static CERT_PATH = 'cert_path'

    static CERT_PATH_TXT = '证书路径'

    static APP_URL = 'app_url'

    static APP_URL_TXT = 'App URL'

    static ALI_PAY_ACCOUNT = 'ali_pay_account'

    static ALI_PAY_ACCOUNT_TXT = '支付宝帐号'

    static PID = 'pid'

    static PID_TXT = '开发者ID'

    static QRCODE_URL = 'qr_code_url'

    static QRCODE_URL_TXT = '二维码网址'

    static ACCOUNT = 'account'

    static WE_CHAT_PAYEE_ACCOUNT_TXT = '微信帐号'

    static QUICK_PAYEE_ACCOUNT_TXT = '云闪付帐号'

    static QRCODE_URL_TIME = 'qr_code_url_time'

    static QRCODE_URL_TIME_TXT = '网址产出时间'

    static enum() {
        return [
            this.APP_ID,
            this.APP_PUBLIC_KEY,
            this.PRIVATE_KEY,
            this.MCH_ID,
            this.CERT_PWD,
            this.CERT_PATH,
            this.APP_URL,
            this.ALI_PAY_ACCOUNT,
            this.PID,
            this.QRCODE_URL,
            this.ACCOUNT,
            this.QRCODE_URL_TIME
        ]
    }

    static summaryMap() {
        return {
            [this.APP_ID]: this.APP_ID_TXT,
            [this.APP_PUBLIC_KEY]: this.APP_PUBLIC_KEY_TXT,
            [this.PRIVATE_KEY]: this.PRIVATE_KEY_TXT,
            [this.MCH_ID]: this.MCH_ID_TXT,
            [this.CERT_PWD]: this.CERT_PWD_TXT,
            [this.CERT_PATH]: this.CERT_PATH_TXT,
            [this.APP_URL]: this.APP_URL_TXT,
            [this.ALI_PAY_ACCOUNT]: this.ALI_PAY_ACCOUNT_TXT,
            [this.PID]: this.PID_TXT,
            [this.QRCODE_URL]: this.QRCODE_URL_TXT,
            [this.ACCOUNT]: {
                [PaymentManage.WE_CHAT_PAYEE_QRCODE]: this.WE_CHAT_PAYEE_ACCOUNT_TXT,
                [PaymentManage.QUICK_PASS_PAYEE_QRCODE]: this.QUICK_PAYEE_ACCOUNT_TXT
            },
            [this.QRCODE_URL_TIME]: this.QRCODE_URL_TIME_TXT
        }
    }

    static specialInput() {
        return {
            [this.QRCODE_URL]: 'qrcode',
            [this.QRCODE_URL_TIME]: 'text-readonly'
        }
    }
}

export {PaymentConnConfig as default}
