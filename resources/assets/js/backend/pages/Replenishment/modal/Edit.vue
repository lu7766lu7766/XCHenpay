<template>
    <div ref="modal" class="modal fade modal-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">补单</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">商户名称 <b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.user_id">
                                    <option value="">请选择商户</option>
                                    <option v-for="company in $parent.options.companies"
                                            :key="company.id"
                                            :value="company.id">
                                        {{ company.company_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">交易状态<b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.pay_state">
                                    <option value="">请选择交易状态</option>
                                    <option v-for="val in $parent.options.payState" :key="val" :value="val">
                                        {{ $parent.config.PayState[val] }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">交易日期 <b>*</b></label>
                            <div class="col-md-9">
                                <date-time-picker v-model="data.pay_time" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">商户交易号</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.trade_service_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">金额<b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">支付方式<b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.payment">
                                    <option value="">请选择支付方式</option>
                                    <option v-for="type in $parent.options.paymentType" :key="type.id" :value="type.i6pay_id">
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">手续费<b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.fee">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">备注<b>*</b></label>
                            <div class="col-md-9">
                                <textarea rows="4" class="form-control" v-model="data.remark"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="submit">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        components: {
            DateTimePicker: require('@/DateTimePicker2')
        },
        rules: {
            'data.user_id': {
                require: {
                    message: '商户名称 不得为空白'
                }
            },
            'data.payment': {
                require: {
                    message: '支付方式 不得为空白'
                }
            },
            'data.pay_state': {
                require: {
                    message: '交易状态 不得为空白'
                }
            },
            'data.amount': {
                require: {
                    message: '金额 不得为空白'
                },
                number: {
                    message: '金额 请输入数字'
                }
            },
            'data.fee': {
                require: {
                    message: '手续费 不得为空白'
                },
                number: {
                    message: '手续费 请输入数字'
                }
            },
            'data.pay_time': {
                require: {
                    message: '交易日期 不得为空白'
                }
            }
        },
        methods: {
            submit() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                const showAlert = !this.data.id
                    ? this.createSuccess
                    : this.updateSuccess
                this.proccessAjax('update', this.data, res => {
                    showAlert()
                    $(this.$refs.modal).modal('hide')
                })
            }
        },
        mounted() {
            this.$root.$on('replenishmentEdit.show', data => {
                const tmpData = data ? _.cloneDeep(data) : { }
                tmpData.pay_time = data ? moment(tmpData.pay_end_time) : moment()
                tmpData.payment = data ? tmpData.payment.i6pay_id : ''
                tmpData.user_id = data ? tmpData.company.id : ''
                this.data = tmpData
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('replenishmentEdit.show')
        }
    }
</script>
