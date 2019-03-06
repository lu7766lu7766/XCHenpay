export default class MessageCategory {
    static SYSTEM = 0

    static FILL_ORDER = 1

    static TRANSACTION = 2

    static SYSTEM_TXT = '系统通知'

    static FILL_ORDER_TXT = '补单通知'

    static TRANSACTION_TXT = '异动通知'

    static enum() {
        return [
            this.SYSTEM,
            this.FILL_ORDER,
            this.TRANSACTION
        ]
    }

    static summaryMap() {
        return {
            [this.SYSTEM]: this.SYSTEM_TXT,
            [this.FILL_ORDER]: this.FILL_ORDER_TXT,
            [this.TRANSACTION]: this.TRANSACTION_TXT
        }
    }
}

