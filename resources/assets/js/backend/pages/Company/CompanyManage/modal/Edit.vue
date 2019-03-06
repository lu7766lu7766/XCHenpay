<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改用戶</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">商户名称 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.company_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">联络电话 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.mobile">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">电子邮箱 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline" v-for="(name, val) in $parent.options.status"
                                       :key="val">
                                    <input type="radio" :value="val" v-model="data.status"> {{ name }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">下发申请 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline" v-for="(name, val) in $parent.options.applyStatus"
                                       :key="val">
                                    <input type="radio" :value="val" v-model="data.apply_status"> {{ name }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">QQ号 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.QQ_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">登入密码</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" v-model="data.password">
                                <div class="tips">
                                    如果您不想更改密码...请将它们留空
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">安全码</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" v-model="data.secret_code">
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
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        rules: {
            'data.password': {
                sometimes: '',
                alpha_dash: {
                    message: '登入密码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '登入密码 长度须大于4'
                }
            },
            'data.secret_code': {
                sometimes: '',
                alpha_dash: {
                    message: '安全码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '安全码 长度须大于4'
                },
                max: {
                    value: 10,
                    message: '安全码 长度须小于10'
                }
            },
            'data.company_name': {
                require: {
                    message: '商户名称 不得为空白'
                }
            },
            'data.mobile': {
                require: {
                    message: '联络电话 不得为空白'
                }
            },
            'data.email': {
                require: {
                    message: '电子邮箱 不得为空白'
                },
                email: {
                    message: '电子邮箱 不符合规定'
                }
            },
            'data.status': {
                require: {
                    message: '状态 不得为空白'
                }
            },
            'data.apply_status': {
                require: {
                    message: '下发状态 不得为空白'
                }
            },
            'data.QQ_id': {
                require: {
                    message: 'QQ号 不得为空白'
                }
            }
        },
        methods: {
            getDetail(id) {
                this.proccessAjax('info', {id}, this.onGetDetail)
            },
            onGetDetail(res) {
                res.data.password = ''
                res.data.secret_code = ''
                this.data = res.data
            },
            update() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('update', this.data, this.onUpdate)
            },
            onUpdate() {
                if (this.data.id === UserInfo.this().getID()) {
                    this.$bus.emit('getUserInfo')
                }
                this.updateSuccess()
                $(this.$refs.modal).modal('hide')
            }
        },
        mounted() {
            this.$root.$on('companyManageEdit.show', id => {
                this.getDetail(id)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('companyManageEdit.show')
        }
    }
</script>

