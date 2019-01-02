class PayState {
    static get PREPARE_CODE () { return 0 }
    static get OPERATING_CODE () { return 1 }
    static get SUCCESS_CODE () { return 2 }
    static get ALL_DONE_CODE () { return 3 }
    static get FAILED_CODE () { return 4 }
    static get PENDING_CODE () { return 5 }
    static get ACCEPT_CODE () { return 6 }
    static get DENY_CODE () { return 7 }
    static get PREPARE () { return '申请成功' }//交易申請成功
    static get OPERATING () { return '交易中' }//等待付费
    static get SUCCESS () { return '交易成功,未回调' }//成功接收金流通知，等待商户接收回调
    static get ALL_DONE () { return '交易结束' }//已可下发
    static get FAILED () { return '交易失败' }
    static get DENY () { return '拒绝下发' }

    static enum() {
        return [
            this.PREPARE_CODE,
            this.OPERATING_CODE,
            this.SUCCESS_CODE,
            this.ALL_DONE_CODE,
            this.FAILED_CODE
        ]
    }

    static summaryMap()
    {
        return {
            [this.PREPARE_CODE]: this.PREPARE,
            [this.OPERATING_CODE] : this.OPERATING,
            [this.SUCCESS_CODE] : this.SUCCESS,
            [this.ALL_DONE_CODE] : this.ALL_DONE,
            [this.FAILED_CODE] : this.FAILED
        }
    }
}

export { PayState as default }
