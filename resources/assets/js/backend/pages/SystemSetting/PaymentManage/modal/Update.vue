<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">名称 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline" v-for="(name, val) in $parent.options.status" :key="val">
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
                                            <input type="text" class="form-control" v-model="data.min_deposit">
                                        </div>
                                    </div>
                                    <div class="form-group col-md row">
                                        <label class="col-md-4 control-label required p-r-0">最高储值 <b>*</b></label>
                                        <div class="col-md control-box">
                                            <input type="text" class="form-control" v-model="data.max_deposit">
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
                                            <input type="text" class="form-control" v-model="data.total_deposit">
                                        </div>
                                    </div>
                                    <div class="form-group col-md day-list">
                                        <div class="">
                                            <label class="radio-inline"
                                                   v-for="(name, val) in $parent.options.deposit_type" :key="val">
                                                <input type="radio" :value="val" v-model="data.deposit_type"> {{ name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">提领金额 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.withdraw">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">金流来源 <b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control selectchange" v-model="data.vendor"
                                        @change="onVendorChanged">
                                    <option value="">请选择</option>
                                    <option v-for="(name, val) in $parent.options.PaymentManageSummary"
                                            :key="val"
                                            :value="val">{{ name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="selectChangeBox">
                            <div class="selectChangeList1">
                                <div class="form-group row" v-for="connKey in connKeys" :key="connKey">
                                    <label class="col-md-3 control-label required">
                                        {{ $parent.config.PaymentConnConfigSummary[connKey]}}
                                        <b>*</b></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="data.conn_config[connKey]">
                                    </div>
                                </div>
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
    import ThisMixins from './mixins'

    export default {
        mixins: [DetailMixins, ThisMixins],
        methods: {
            submit() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('update', {
                    user_id: UserInfo.this().getID(),
                    ..._.pick(this.data, [
                        'id',
                        'name',
                        'status',
                        'min_deposit',
                        'max_deposit',
                        'total_deposit',
                        'deposit_type',
                        'withdraw',
                        'vendor',
                        'conn_config'
                    ])
                }, _ => {
                    this.updateSuccess()
                    $(this.$refs.modal).modal('hide')
                })
            }
        },
        mounted() {
            this.$root.$on('paymentManageUpdate.show', data => {
                this.proccessAjax('detail', {id: data.id}, res => {
                    this.data = res.data
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('paymentManageUpdate.show')
        }
    }
</script>
