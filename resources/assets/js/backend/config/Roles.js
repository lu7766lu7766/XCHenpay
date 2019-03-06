class Roles {
    static ADMIN = 'admin'
    static CUSTOMER = 'customer_service'
    static FINANCE = 'finance'
    static USER = 'user'
    static ADMIN_TXT = '管理者'
    static CUSTOMER_TXT = '客服'
    static FINANCE_TXT = '财务'
    static USER_TXT = '商户'

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
