class Roles {
    static get ADMIN() {
        return 'admin'
    }

    static get CUSTOMER() {
        return 'customer_service'
    }

    static get FINANCE() {
        return 'finance'
    }

    static get USER() {
        return 'user'
    }

    static get ADMIN_TXT() {
        return '管理者'
    }

    static get CUSTOMER_TXT() {
        return '客服'
    }

    static get FINANCE_TXT() {
        return '财务'
    }

    static get USER_TXT() {
        return '商户'
    }

    static summaryMap() {
        return {
            [this.ADMIN]: this.ADMIN_TXT,
            [this.CUSTOMER]: this.CUSTOMER_TXT,
            [this.FINANCE]: this.FINANCE_TXT,
            [this.USER]: this.USER_TXT
        }
    }
}

export {Roles as default}
