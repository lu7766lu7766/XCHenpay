<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">交易状态修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">系統交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_seq }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">商户交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_service_id }}</div>
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
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model.number="data.real_paid_amount"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">交易状态</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.pay_state">
                                    <option v-for="(name, val) in stateList" :key="val" :value="val">{{ name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="selectChangeBox" v-if="isShowEndTime">
                            <div class="selectChangeList1">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">完成時間</label>
                                    <div class="col-md-9">
                                        <date-time-picker v-model="data.pay_end_time"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="update">确定
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
        components: {
            DateTimePicker: require('@/DateTimePickerInput')
        },
        data: () => ({
            stateList: {}
        }),
        watch: {
            'data.pay_state'() {
                if (!this.isShowEndTime) {
                    this.data.pay_end_time = null
                }
            }
        },
        methods: {
            getState(data) {
                this.callApi(async () => {
                    await this.$api.search.orderSearch.getState(data, {
                        s: res => {
                            this.data = res.authcode
                            this.stateList = res.stateList
                        }
                    })
                })
            },
            update() {
                this.callApi(async () => {
                    await this.$api.search.orderSearch.update({
                        id: this.data.id,
                        state: this.data.pay_state,
                        real_paid_amount: this.data.real_paid_amount,
                        pay_end_time: this.data.pay_end_time
                    }, {
                        s: () => {
                            this.updateSuccess()
                            $(this.$refs.modal).modal('hide')
                        }
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
            this.$root.$on('orderState.show', authcode => {
                this.getState({
                    authcode
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('orderState.show')
        }
    }
</script>
