class PaymentManageDepositType {
    static get DAILY() {
        return 'daily'
    }

    static get WEEKLY() {
        return 'weekly'
    }

    static get MONTHLY() {
        return 'monthly'
    }

    static get DAILY_TXT() {
        return '每日计算'
    }

    static get WEEKLY_TXT() {
        return '每周计算'
    }

    static get MONTHLY_TXT() {
        return '每月计算'
    }

    static summaryMap() {
        return {
            [this.DAILY]: this.DAILY_TXT,
            [this.WEEKLY]: this.WEEKLY_TXT,
            [this.MONTHLY]: this.MONTHLY_TXT,
        }
    }
}

export {PaymentManageDepositType as default}
