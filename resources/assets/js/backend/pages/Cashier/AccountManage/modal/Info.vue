<template>
    <div ref="modal" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">內容</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">商户名称</label>
                            <div class="col-md-9 p-t-7" v-if="data.personal">
                                {{ data.personal[0].company_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">CardID</label>
                            <div class="col-md-9 p-t-7">
                                {{ getCardID(data.payment) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">开户名</label>
                            <div class="col-md-9 p-t-7">
                                {{ data.user_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行卡号</label>
                            <div class="col-md-9 p-t-7">
                                {{ data.card_no }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名</label>
                            <div class="col-md-9 p-t-7">
                                {{ data.bank_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">通道类型</label>
                            <div class="col-md-9 p-t-7">
                                <span class="badge badge-payway">{{ getPaymentName(data.payment) }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态</label>
                            <div class="col-md-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.status == 'Y'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg"
                                   v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">限制金额</label>
                            <div class="col-sm-9 p-t-7">
                                <div class="stored-txt">
                                    <span>最低储值:
                                        <i class="text-red price"> {{ data.minimum_amount | numFormat('0,0') }} </i>
                                    </span>
                                    <span>最高储值:
                                        <i class="text-red price"> {{ data.maximum_amount | numFormat('0,0') }} </i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group row">-->
                        <!--<label class="col-sm-3 control-label">总储值金额</label>-->
                        <!--<div class="col-sm-9 p-t-7">-->
                        <!--<i class="text-red price">3,000,000</i>-->
                        <!--<span class="badge badge-day">每日计算</span>-->
                        <!--&lt;!&ndash; <span class="badge badge-week">每周计算</span>-->
                        <!--<span class="badge badge-month">每月计算</span> &ndash;&gt;-->
                        <!--</div>-->
                        <!--</div>-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'
    import ThisMixins from '../mixins'

    export default {
        mixins: [DetailMixins, ThisMixins],
        mounted() {
            this.$root.$on('accountManageInfo.show', data => {
                this.proccessAjax('info', {id: data.id}, res => {
                    this.data = res.data
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('accountManageInfo.show')
        }
    }
</script>

