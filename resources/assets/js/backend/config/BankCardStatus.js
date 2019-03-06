class BankCardStatus {
    static PENDING = 'pending'

    static REJECT = 'reject'

    static APPROVAL = 'approval'

    static PENDING_TXT = '处理中'

    static REJECT_TXT = '不通过'

    static APPROVAL_TXT = '已通过'

    static enum() {
        return [
            this.PENDING,
            this.REJECT,
            this.APPROVAL
        ]
    }

    static summaryMap() {
        return {
            [this.PENDING]: this.PENDING_TXT,
            [this.REJECT]: this.REJECT_TXT,
            [this.APPROVAL]: this.APPROVAL_TXT
        }
    }

    static updateSummaryMap() {
        return {
            [this.REJECT]: this.REJECT_TXT,
            [this.APPROVAL]: this.APPROVAL_TXT
        }
    }
}

export {BankCardStatus as default}
