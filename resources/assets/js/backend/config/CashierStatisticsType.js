class CashierStatisticsType {
    static DAY = 'day'

    static WEEK = 'week'

    static MONTH = 'month'

    static DAY_TXT = '每日计算'

    static WEEK_TXT = '每周计算'

    static MONTH_TXT = '每月计算'

    static enum() {
        return [
            this.DAY,
            this.WEEK,
            this.MONTH
        ]
    }

    static summaryMap() {
        return {
            [this.DAY]: this.DAY_TXT,
            [this.WEEK]: this.WEEK_TXT,
            [this.MONTH]: this.MONTH_TXT
        }
    }
}

export {CashierStatisticsType as default}
