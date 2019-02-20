class CashierStatisticsType {
    static get DAY() {
        return 'day'
    }

    static get WEEK() {
        return 'week'
    }

    static get MONTH() {
        return 'month'
    }

    static get DAY_TXT() {
        return '每日计算'
    }

    static get WEEK_TXT() {
        return '每周计算'
    }

    static get MONTH_TXT() {
        return '每月计算'
    }

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
