<template>
    <div ref="modal" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">下发资讯: {{ data.record_seq }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">下发状态</label>
                            <div class="col-md-9 p-t-7">{{ data.lend_summary }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">单号</label>
                            <div class="col-md-9 p-t-7">{{ data.record_seq }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">户名</label>
                            <div class="col-md-9 p-t-7" v-if="data.account">{{ data.account.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">银行卡号</label>
                            <div class="col-md-9 p-t-7" v-if="data.account">{{ data.account.account }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">银行名</label>
                            <div class="col-md-9 p-t-7" v-if="data.account">{{ data.account.bank_name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">开户支行</label>
                            <div class="col-md-9 p-t-7" v-if="data.account">{{ data.account.bank_branch }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">申请金额</label>
                            <div class="col-md-9 p-t-7">{{ data.amount | numFormat('0,0.000') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">下发手续费</label>
                            <div class="col-md-9 p-t-7">{{ data.fee | numFormat('0,0.000') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">下发金额</label>
                            <div class="col-md-9 p-t-7">{{ (data.amount - data.fee) | numFormat('0,0.000') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">备注</label>
                            <div class="col-md-9 p-t-7">{{ data.review_note }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">申请时间</label>
                            <div class="col-md-9 p-t-7">{{ data.created_at }}</div>
                        </div>
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

    export default {
        mixins: [DetailMixins],
        mounted() {
            this.$root.$on('lendManageInfo.show', data => {
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('lendManageInfo.show')
        }
    }
</script>

