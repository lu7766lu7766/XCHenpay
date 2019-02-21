class PaymentConnConfig {
    static get APP_ID() {
        return 'app_id'
    }

    static get APP_ID_TXT() {
        return '应用ID'
    }

    static get APP_PUBLIC_KEY() {
        return 'app_public_key'
    }

    static get APP_PUBLIC_KEY_TXT() {
        return '公钥'
    }

    static get PRIVATE_KEY() {
        return 'private_key'
    }

    static get PRIVATE_KEY_TXT() {
        return '私钥'
    }

    static get MCH_ID() {
        return 'mch_id'
    }

    static get MCH_ID_TXT() {
        return '商户ID'
    }

    static get CERT_PWD() {
        return 'cert_pwd'
    }

    static get CERT_PWD_TXT() {
        return '证书密码'
    }

    static get CERT_PATH() {
        return 'cert_path'
    }

    static get CERT_PATH_TXT() {
        return '证书路径'
    }

    static get APP_URL() {
        return 'app_url'
    }

    static get APP_URL_TXT() {
        return 'App URL'
    }

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
