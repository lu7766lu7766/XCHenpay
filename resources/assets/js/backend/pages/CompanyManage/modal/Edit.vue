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
                            <label class="col-sm-3 control-label">密码</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="data.password">
                                <div class="tips">
                                    如果您不想更改密码...请将它们留空
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">密码确认</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="data.password_confirm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">权限 <b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.role_id">
                                    <option value="">请选择</option>
                                    <option v-for="role in $parent.options.roleList" :key="role.id" :value="role.id">
                                        {{ role.name }}
                                    </option>
                                </select>
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
    import ThisMixins from './mixins'

    export default {
        mixins: [DetailMixins, ThisMixins],
        methods: {
            getDetail(id) {
                this.proccessAjax('info', {id}, this.onGetDetail)
            },
            onGetDetail(res) {
                res.data.role_id = res.data.roles[0] ? res.data.roles[0].id : ''
                // res.data.password = ''
                // res.data.password_confirm = ''
                this.data = res.data
            },
            update() {
                try{
                    this.validate()
                } catch(e) {
                    return alert(e)
                }
                this.proccessAjax('update', this.data, this.onUpdate)
            },
            onUpdate() {
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

