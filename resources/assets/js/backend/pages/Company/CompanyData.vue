<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">商戶名稱</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.company_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">company_service_id</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.company_service_id }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">sceret_key</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.sceret_key }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.status == 'on'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg" v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">下发申请</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.apply_status == 'on'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg" v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">联络电话</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.mobile }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">电子邮箱</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.email }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">QQ号</label>
                            <div class="col-sm-10 p-t-7 border-line">
                                {{ data.QQ_id }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">旧登入密码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入旧登入密码"
                                       v-model="data.old_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">新登入密码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入新登入密码"
                                       v-model="data.password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">确认新登入密码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请确认新登入密码"
                                       v-model="data.password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">旧安全码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入旧安全码"
                                       v-model="data.old_secret_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">新安全码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入新安全码"
                                       v-model="data.secret_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">确认新安全码 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请确认新安全码"
                                       v-model="data.secret_code_confirmation">
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary waves-effect waves-light" @click="submit">
                                    提交
                                </button>
                                <button type="button" class="btn btn-secondary waves-effect" @click="dataInit">重设
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- card end -->
        </div>
    </div>
</template>

<script>
    import ReqMixins from "mixins/request"

    export default {
        api: 'companyData',
        mixins: [ReqMixins],
        rules: {
            'data.old_password': {
                sometimes: '',
                alpha_dash: {
                    message: '旧登入密码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '旧登入密码 长度须大于4'
                }
            },
            'data.password': {
                sometimes: '',
                alpha_dash: {
                    message: '新登入密码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '新登入密码 长度须大于4'
                }
            },
            'data.password_confirmation': {
                equal: {
                    value: 'data.password',
                    message: '确认新登入密码 内容与密码不符合'
                }
            },
            'data.old_secret_code': {
                sometimes: '',
                alpha_dash: {
                    message: '旧安全码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '旧安全码 长度须大于4'
                },
                max: {
                    value: 10,
                    message: '旧安全码 长度须小于10'
                }
            },
            'data.secret_code': {
                sometimes: '',
                alpha_dash: {
                    message: '新安全码 内含不合法字元'
                },
                min: {
                    value: 4,
                    message: '新安全码 长度须大于4'
                },
                max: {
                    value: 10,
                    message: '新安全码 长度须小于10'
                }
            },
            'data.secret_code_confirmation': {
                equal: {
                    value: 'data.secret_code',
                    message: '确认新安全码 内容与密码不符合'
                }
            },
        },
        data: () => ({
            data: {},
            dataProperties: [
                'old_password',
                'password',
                'password_confirmation',
                'old_secret_code',
                'secret_code',
                'secret_code_confirmation'
            ]
        }),
        watch: {
            userInfo(newVal, oldVal) {
                _.isEqual(newVal, oldVal) ? '' : this.dataInit()
            }
        },
        methods: {
            dataInit() {
                const data = _.cloneDeep(this.userInfo)
                _.forEach(this.dataProperties, property => {
                    data[property] = ''
                })
                this.data = data
            },
            submit() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('update', _.pick(this.data, this.dataProperties), res => {
                    if (res.data) {
                        this.dataInit()
                        alert('更新成功')
                    } else {
                        alert('更新失败')
                    }
                })
            }
        },
        computed: {
            userInfo() {
                return UserInfo.this().getUser()
            },
        },
        mounted() {
            this.dataInit()
        }
    }
</script>
