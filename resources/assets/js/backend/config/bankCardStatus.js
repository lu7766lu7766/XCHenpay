class BankCardStatus {
    static get PENDING() {
        return 'pending'
    }

    static get REJECT() {
        return 'reject'
    }

    static get APPROVAL() {
        return 'approval'
    }

    static get PENDING_TXT() {
        return '处理中'
    }

    static get REJECT_TXT() {
        return '不通过'
    }

    static get APPROVAL_TXT() {
        return '已通过'
    }

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
