<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">新增行卡</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">验证码 <b>*</b></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="data.code">
                                    <div class="input-group-append">
                                        <button type="button" class="btn input-group-text" @click="sendVerify">发送验证码
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">开户名 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行卡号 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.bank_account">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.bank_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">开户支行 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.bank_branch">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="create">确定
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
        rules: {
            'data.code': {
                require: {
                    message: '验证码 不得为空白'
                }
            },
            'data.name': {
                require: {
                    message: '开户名 不得为空白'
                }
            },
            'data.bank_account': {
                require: {
                    message: '银行卡号 不得为空白'
                }
            },
            'data.bank_name': {
                require: {
                    message: '银行名 不得为空白'
                }
            },
            'data.bank_branch': {
                require: {
                    message: '开户支行 不得为空白'
                }
            },
            '$parent.paginate.total': {
                max: {
                    value: (20 - 1), // 因20符合資格，還是可以送出，所以需要減一
                    message: '行卡数量 不得大于20'
                }
            }
        },
        methods: {
            dataInit() {
                this.data = {
                    code: '',
                    name: '',
                    bank_account: '',
                    bank_name: '',
                    bank_branch: ''
                }
            },
            async sendVerify() {
                var res = await this.proccessAjax('verify')
                if (res.data.result === 'success') {
                    alert('简讯已发送，请留意手机讯息')
                }
            },
            create() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('create', this.data, this.onCreate)
            },
            onCreate() {
                this.createSuccess()
                $(this.$refs.modal).modal('hide')
            },
        },
        computed: {
            bankAccount() {
                return this.$parent.options.bankAccount
            }
        },
        mounted() {
            this.$root.$on('bankAccountBindCreate.show', () => {
                this.dataInit()
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('bankAccountBindCreate.show')
        }
    }
</script>

