<template>
    <div ref="modal" class="modal fade modal-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">{{ title }}</h5>
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
                            <label class="col-md-3 control-label required">电子邮箱  <b>*</b></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" v-model="data.email">
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
                            <label class="col-md-3 control-label required">权限 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <select class="form-control" v-model="data.role_id">
                                    <option v-for="(role, index) in $parent.options.roles"
                                            :key="index"
                                            :value="role.id"> {{ role.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">密码<b>*</b></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" v-model="data.password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">确认密码<b>*</b></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" v-model="data.password_confirm">
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

    const rulesSource = {
        'data.password': {
            min: {
                value: 4,
                message: '密码 长度须大于4'
            },
            max: {
                value: 16,
                message: '密码 长度须小于16'
            }
        },
        'data.password_confirm': {
            equal: {
                value: 'data.password',
                message: '确认密码 内容与密码不符合'
            }
        },
        'data.company_name': {
            require: {
                message: '商户名称 不得为空白'
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
        'data.role_id': {
            require: {
                message: '权限 不得为空白'
            }
        }
    }
    export default {
        mixins: [DetailMixins],
        data: () => ({
            type: '',
            title: ''
        }),
        rules: _.cloneDeep(rulesSource),
        methods: {
            createInit() {
                this.title = '新增'
                this.data = {}
                _.mergeWith(this.$options.rules, {
                    'data.password': {
                        require: {
                            message: '密码 不得为空白'
                        }
                    },
                    'data.password_confirm': {
                        require: {
                            message: '确认密码 不得为空白'
                        }
                    }
                }, (oValue, nValue) => {
                    return _.assign(oValue, nValue)
                })
            },
            updateInit(data) {
                this.title = '修改'
                this.data = _.cloneDeep(data)
                this.data.role_id = this.data.roles[0].id
                _.mergeWith(this.$options.rules, {
                    'data.password': {
                        sometimes: '',
                    }
                }, (oValue, nValue) => {
                    return _.assign(oValue, nValue)
                })
            },
            commonInit(){
                _.assign(this.data, {
                    password: '',
                    password_confirm: ''
                })
            },
            submit() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax(this.type, {
                    id: this.data.id,
                    company_name: this.data.company_name,
                    email: this.data.email,
                    password: this.data.password,
                    password_confirmation: this.data.password_confirm,
                    status: this.data.status,
                    role_id: this.data.role_id
                }, _ => {
                    this[this.type + 'Success']()
                    $(this.$refs.modal).modal('hide')
                })
            }
        },
        mounted() {
            this.$root.$on('accountManageDetail.show', data => {
                this.type = data ? 'update': 'create'
                this.$options.rules = _.cloneDeep(rulesSource)
                this[this.type+'Init'](data)
                this.commonInit()
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('accountManageDetail.show')
        }
    }
</script>
