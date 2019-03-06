class PaymentManageDepositType {
    static DAILY = 'daily'

    static WEEKLY = 'weekly'

    static MONTHLY = 'monthly'

    static DAILY_TXT = '每日计算'

    static WEEKLY_TXT = '每周计算'

    static MONTHLY_TXT = '每月计算'

    static summaryMap() {
        return {
            [this.DAILY]: this.DAILY_TXT,
            [this.WEEKLY]: this.WEEKLY_TXT,
            [this.MONTHLY]: this.MONTHLY_TXT,
        }
    }
}

export {PaymentManageDepositType as default}
