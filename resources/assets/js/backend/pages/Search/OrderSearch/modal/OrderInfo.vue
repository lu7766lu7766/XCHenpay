<template>
    <div ref="modal" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">订单资讯:{{ data.trade_seq }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">交易状态</label>
                            <div class="col-md-9 p-t-7">{{ data.pay_summary }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">系統交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_seq }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">商户交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_service_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">交易模式</label>
                            <div class="col-md-9 p-t-7" v-if="data.trade_type">{{ data.trade_type.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">用户代码</label>
                            <div class="col-md-9 p-t-7">{{ data.customer_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">品项名称</label>
                            <div class="col-md-9 p-t-7">{{ data.item_name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">订单金额</label>
                            <div class="col-md-9 p-t-7">{{ data.amount | numFormat('0,0.00') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">应付金额</label>
                            <div class="col-md-9 p-t-7">{{ +data.amount - (+data.rand_fee) | numFormat('0,0.00') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">实付金额</label>
                            <div class="col-md-9 p-t-7">{{ data.real_paid_amount | numFormat('0,0.00') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">手续费</label>
                            <div class="col-md-9 p-t-7">{{ data.fee | numFormat('0,0.000') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">币别</label>
                            <div class="col-md-9 p-t-7" v-if="data.currency">{{ data.currency.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">回调链结</label>
                            <div class="col-md-9 p-t-7 text-break-all">
                                {{ data.notify_url }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">申请时间</label>
                            <div class="col-md-9 p-t-7">{{ data.created_at }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">支付时间</label>
                            <div class="col-md-9 p-t-7">{{ data.pay_start_time }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">完成时间</label>
                            <div class="col-md-9 p-t-7">
                                <span v-if="isShowEndTime">{{ data.pay_end_time }}</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>

<script>
    import DetailMixins from 'mixins/detail'
    import PayState from 'config/PayState'

    export default {
        mixins: [DetailMixins],
        methods: {
            onGetInfo(res) {
                this.data = res.authcode
            },
            async getInfo(data) {
                this.callApi(async () => {
                    await this.$api.search.orderSearch.getInfo(data, {
                        s: this.onGetInfo
                    })
                })
            }
        },
        computed: {
            isShowEndTime() {
                // 交易完成，未回條，交易結束
                return [PayState.SUCCESS_CODE, PayState.ALL_DONE_CODE].indexOf(this.data.pay_state) > -1
            }
        },
        mounted() {
            this.$root.$on('orderInfo.show', authcode => {
                this.getInfo({
                    authcode
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('orderInfo.show')
        }
    }
</script>

