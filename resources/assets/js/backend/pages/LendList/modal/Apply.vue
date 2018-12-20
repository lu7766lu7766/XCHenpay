<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">申请</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal delivery-form">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">驗證碼<b>*</b></label>
                            <div class="col-md-9">
                                <div class="code">
                                    <input type="text" class="form-control" v-model="verify_code">
                                    <button type="button" class="btn btn-code" @click="sendVerifyCode">獲取驗證碼</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">下发金额<b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model.number="amount">
                                <div class="tips">
                                    下发金额 最少填入 1000, 最大不可超过 50000
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">下发帐号<b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="target_id">
                                    <option value="">请选择银行卡 (开户名/银行卡号/银行名)</option>
                                    <option v-for="(account, index) in bankAccount" :key="index" :value="account.id">
                                        {{ `${account.name}/${account.account}/${account.bank_name}` }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">备注</label>
                            <div class="col-md-9">
                                <textarea cols="30" rows="4" class="form-control" v-model="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-md-9 text-red">
                                申请金额将自动加上 0.02% 的申请手续费
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="apply">下发申请
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        data: () => ({
            target_id: '',
            amount: '',
            note: '',
            verify_code: ''
        }),
        rules: {
            amount: {
                require: {
                    message: '下发金额 不得为空白'
                },
                type: {
                    value: 'number',
                    message: '下发金额 请输入数字'
                },
                min: {
                    value: 1000,
                    message: '下发金额 最少填入 1000'
                },
                max: {
                    value: 50000,
                    message: '下发金额 最大不可超过 50000'
                }
            },
            verify_code: {
                require: {
                    message: '验证码 不得为空白'
                }
            }
        },
        methods: {
            dataInit() {
                this.target_id = ''
                this.amount = ''
                this.note = ''
                this.verify_code = ''
            },
            onApply() {
                this.createSuccess()
                this.$parent.amountInit()
                $(this.$refs.modal).modal('hide')
            },
            apply() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('apply', {
                    target_id: this.target_id, //	下發帳戶ID
                    amount: this.amount, //	下發金額
                    note: this.note, //
                    code: this.verify_code
                }, this.onApply)
            },
            sendVerifyCode() {
                this.proccessAjax('sendVerifyCode', {}, res => {
                    if (res.data.result == 'success') {
                        alert('验证码已发送至您的手机，请留意讯息')
                    }
                })
            }
        },
        computed: {
            bankAccount() {
                return this.$parent.options.bankAccount
            }
        },
        mounted() {
            this.$root.$on('lendListApply.show', () => {
                this.dataInit()
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('lendListApply.show')
        }
    }
</script>

