<template>
    <div ref="modal" id="info" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">內容</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">名称</label>
                            <div class="col-sm-9 p-t-7">{{ data.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.status == 'on'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg" v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">限制金额</label>
                            <div class="col-sm-9 p-t-7">
                                <div class="stored-txt">
                                    <span>最低储值:<i
                                            class="text-red price">{{ data.min_deposit | numFormat('0,0') }}</i></span>
                                    <span>最高储值:<i
                                            class="text-red price">{{ data.max_deposit | numFormat('0,0') }}</i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">总储值金额</label>
                            <div class="col-sm-9 p-t-7">
                                <i class="text-red price">{{ data.total_deposit | numFormat('0,0') }}</i>&nbsp
                                <span class="badge" :class="{
                                    'badge-day' : data.deposit_type == $parent.config.PaymentManageDepositType.DAILY,
                                    'badge-week' : data.deposit_type == $parent.config.PaymentManageDepositType.WEEKLY,
                                    'badge-month' : data.deposit_type == $parent.config.PaymentManageDepositType.MONTHLY
                                }">
                                    {{ $parent.options.deposit_type[data.deposit_type] }}
                                </span>
                                <!-- <span class="badge badge-week">每周计算</span>
                                <span class="badge badge-month">每月计算</span> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">提领金额</label>
                            <div class="col-sm-9 p-t-7">
                                <i class="text-red price">{{ data.withdraw | numFormat('0,0') }}</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">金流来源</label>
                            <div class="col-sm-9 p-t-7">
                                <span class="badge badge-payway">
                                    {{ $parent.options.PaymentManageSummary[data.vendor] }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row" v-for="connKey in connKeys" :key="connKey">
                            <label class="col-sm-3 control-label">
                                {{ $parent.config.PaymentConnConfigSummary[connKey] }}
                            </label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.conn_config[connKey]}}
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button> -->
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">关闭
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
        mounted() {
            this.$root.$on('paymentManageInfo.show', data => {
                this.proccessAjax('detail', {id: data.id}, res => {
                    this.data = res.data
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('paymentManageInfo.show')
        }
    }
</script>
