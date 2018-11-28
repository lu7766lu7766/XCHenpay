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
            note: ''
        }),
        rules: {
            amount: {
                require: {
                    value: true,
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
            }
        },
        methods: {
            dataInit() {
                this.target_id = ''
                this.amount = ''
                this.note = ''
            },
            onApply() {
                this.$parent.refresh()
                this.$parent.amountInit()
                $(this.$refs.modal).modal('hide')
            },
            apply() {
                // if (typeof this.amount !== 'number' || this.amount < 1000 || this.amount > 5000) {
                //     alert('下发金额 最少填入 1000, 最大不可超过 50000')
                //     return
                // }
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('apply', {
                    target_id: this.target_id, //	下發帳戶ID
                    amount: this.amount, //	下發金額
                    note: this.note //
                }, this.onApply)
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

