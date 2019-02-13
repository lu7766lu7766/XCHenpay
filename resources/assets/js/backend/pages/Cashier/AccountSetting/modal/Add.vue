<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">新增</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">CardID</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.card_id">
                                <div class="tips text-danger">
                                    隐藏银行卡号使用, 若无输入, 则无法隐藏银行卡号 <a href="" class="text-blue">(支付宝获取说明)</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">开户名 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.user_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行卡号 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.card_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名 <b>*</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="data.bank_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">通道类型 <b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.channel">
                                    <option value="">请选择</option>
                                    <option v-for="channel in $parent.options.channel"
                                            :key="channel.id"
                                            :value="channel.i6pay_id">{{ channel.name }}
                                    </option>
                                </select>
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
                        <!--<div class="form-group row">-->
                        <!--<label class="col-md-3 control-label required">限制金额 <b>*</b></label>-->
                        <!--<div class="col-md-9">-->
                        <!--<div class="row stored-box">-->
                        <!--<div class="form-group col-md row">-->
                        <!--<label class="col-md-4 control-label required p-r-0">最低储值 <b>*</b></label>-->
                        <!--<div class="col-md control-box">-->
                        <!--<input type="text" class="form-control" disabled>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="form-group col-md row">-->
                        <!--<label class="col-md-4 control-label required p-r-0">最高储值 <b>*</b></label>-->
                        <!--<div class="col-md control-box">-->
                        <!--<input type="text" class="form-control" disabled>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="form-group row">-->
                        <!--<label class="col-md-3 control-label required">总储值金额 <b>*</b></label>-->
                        <!--<div class="col-md-9">-->
                        <!--<div class="row stored-total-box">-->
                        <!--<div class="form-group col-md">-->
                        <!--<div class="control-box">-->
                        <!--<input type="text" class="form-control" disabled>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="form-group col-md day-list">-->
                        <!--<div class="p-t-7">-->
                        <!--<label class="radio-inline">-->
                        <!--<input type="radio" value="option1" disabled> 每日计算-->
                        <!--</label>-->
                        <!--<label class="radio-inline">-->
                        <!--<input type="radio" value="option2" disabled> 每周计算-->
                        <!--</label>-->
                        <!--<label class="radio-inline">-->
                        <!--<input type="radio" value="option2" disabled> 每月计算-->
                        <!--</label>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="create">确定</button>
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
            "data.user_name": {
                require: {
                    message: '开户名 不得为空白'
                }
            },
            "data.card_no": {
                require: {
                    message: '银行卡号 不得为空白'
                }
            },
            "data.bank_name": {
                require: {
                    message: '银行名 不得为空白'
                }
            },
            "data.channel": {
                require: {
                    message: '通道类型 不得为空白'
                }
            },
            "data.status": {
                require: {
                    message: '状态 不得为空白'
                }
            }
        },
        methods: {
            create() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('create', _.pick(this.data, [
                    'card_id',
                    'user_name',
                    'card_no',
                    'bank_name',
                    'channel',
                    'status'
                ]), this.onCreate)
            },
            onCreate() {
                this.createSuccess()
                $(this.$refs.modal).modal('hide')
            }
        },
        mounted() {
            this.$root.$on('accountSettingAdd.show', () => {
                this.data = {
                    channel: '',
                    status: 'Y'
                }
                $(this.$refs.modal).modal('show')
            })

        },
        destroyed() {
            this.$root.$off('accountSettingAdd.show')
        }
    }
</script>

