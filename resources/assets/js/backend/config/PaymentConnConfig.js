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

    static enum() {
        return [this.APP_ID, this.APP_PUBLIC_KEY, this.PRIVATE_KEY, this.MCH_ID, this.CERT_PWD, this.CERT_PATH, this.APP_URL]
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
        }
    }
}

export {PaymentConnConfig as default}
