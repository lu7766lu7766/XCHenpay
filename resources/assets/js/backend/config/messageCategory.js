export default class MessageCategory {
    static get SYSTEM() {
        return 0
    }

    static get FILL_ORDER() {
        return 1
    }

    static get TRANSACTION() {
        return 2
    }

    static get SYSTEM_TXT() {
        return '系统通知'
    }

    static get FILL_ORDER_TXT() {
        return '补单通知'
    }

    static get TRANSACTION_TXT() {
        return '异动通知'
    }

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

