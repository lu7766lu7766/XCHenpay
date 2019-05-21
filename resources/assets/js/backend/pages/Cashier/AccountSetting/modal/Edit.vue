<template>
    <div ref="modal" class="modal info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">CardID</label>
                            <div class="col-md-9 p-t-7">
                                <input type="text" class="form-control" v-model="data.card_id">
                                <div class="tips text-danger">
                                    隐藏银行卡号使用, 若无输入, 则无法隐藏银行卡号 <a href="" class="text-blue">(支付宝获取说明)</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">开户名 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                {{ data.user_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行卡号 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                {{ data.card_no }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                {{ data.bank_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">通道类型 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <span class="badge badge-payway">{{ getPaymentName(data.payment) }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline"
                                       v-for="(name, val) in $parent.options.status"
                                       :key="val">
                                    <input type="radio" :value="val" v-model="data.status"> {{ name }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">限制金额 <b>*</b></label>
                            <div class="col-md-9">
                                <div class="row stored-box">
                                    <div class="form-group col-md row">
                                        <label class="col-md-4 control-label required p-r-0">最低储值 <b>*</b></label>
                                        <div class="col-md control-box">
                                            <input type="text" class="form-control" v-model="data.minimum_amount">
                                        </div>
                                    </div>
                                    <div class="form-group col-md row">
                                        <label class="col-md-4 control-label required p-r-0">最高储值 <b>*</b></label>
                                        <div class="col-md control-box">
                                            <input type="text" class="form-control" v-model="data.maximum_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">总储值金额 <b>*</b></label>
                            <div class="col-md-9">
                                <div class="row stored-total-box">
                                    <div class="form-group col-md">
                                        <div class="control-box">
                                            <input type="text" class="form-control" v-model="data.total_amount">
                                        </div>
                                    </div>
                                    <div class="form-group col-md day-list">
                                        <div class="">
                                            <label class="radio-inline"
                                                   v-for="(name, val) in $parent.options.CashierStatisticsTypeSummary"
                                                   :key="val">
                                                <input type="radio" :value="val" v-model="data.statistics_type">
                                                {{ name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="update">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'
    import PaymentMixins from 'mixins/payment'

    export default {
        mixins: [DetailMixins, PaymentMixins],
        rules: {
            "data.status": {
                require: {
                    message: '状态 不得为空白'
                }
            },
            'data.minimum_amount': {
                require: {
                    message: '最低储值 不得为空白'
                },
                number: {
                    message: '最低储值 请输入数字'
                }
            },
            'data.maximum_amount': {
                require: {
                    message: '最高储值 不得为空白'
                },
                number: {
                    message: '最高储值 请输入数字'
                },
                min: {
                    value: 'data.minimum_amount',
                    message: '最高储值 不可低于 最低储值'
                }
            },
            'data.total_amount': {
                require: {
                    message: '总储值金额 不得为空白'
                },
                number: {
                    message: '总储值金额 请输入数字'
                }
            }
        },
        methods: {
            update() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.callApi(async () => {
                    await this.$api.cashier.accountSetting.update(_.pick(this.data, [
                        'id',
                        'card_id',
                        'status',
                        'minimum_amount',
                        'maximum_amount',
                        'total_amount',
                        'statistics_type',
                    ]), {
                        s: this.onUpdate
                    })
                })
            },
            onUpdate() {
                this.updateSuccess()
                $(this.$refs.modal).modal('hide')
            }
        },
        mounted() {
            this.$root.$on('accountSettingEdit.show', data => {
                this.data = _.cloneDeep(data)
                this.data.card_id = this.getCardID(this.data.payment)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('accountSettingEdit.show')
        }
    }
</script>

