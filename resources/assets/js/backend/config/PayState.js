class PayState {
    static PREPARE_CODE = 0
    static OPERATING_CODE = 1
    static SUCCESS_CODE = 2
    static ALL_DONE_CODE = 3
    static FAILED_CODE = 4
    static AMOUNT_NOT_MATCH_CODE = 5
    static ACCEPT_CODE = 6
    static DENY_CODE = 7
    static PREPARE = '申请成功' //交易申請成功
    static OPERATING = '交易中' //等待付费
    static SUCCESS = '交易成功,未回调' //成功接收金流通知，等待商户接收回调
    static ALL_DONE = '交易结束' //已可下发
    static FAILED = '交易失败'
    static AMOUNT_NOT_MATCH = '交易失败,交易金额不合';
    static DENY = '拒绝下发'

    static enum() {
        return [
            this.PREPARE_CODE,
            this.OPERATING_CODE,
            this.SUCCESS_CODE,
            this.ALL_DONE_CODE,
            this.FAILED_CODE,
            this.AMOUNT_NOT_MATCH_CODE
        ]
    }

    static summaryMap()
    {
        return {
            [this.PREPARE_CODE]: this.PREPARE,
            [this.OPERATING_CODE] : this.OPERATING,
            [this.SUCCESS_CODE] : this.SUCCESS,
            [this.ALL_DONE_CODE] : this.ALL_DONE,
            [this.FAILED_CODE]: this.FAILED,
            [this.AMOUNT_NOT_MATCH_CODE]: this.AMOUNT_NOT_MATCH
        }
    }
}

export { PayState as default }
