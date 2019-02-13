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
                            <label class="col-md-3 control-label">核卡状态</label>
                            <div class="col-md-9 p-t-7">
                                <span class="badge badge-pill"
                                      :class="{
                                            'badge-warning': data.status == $parent.config.BankCardStatus.PENDING,
                                            'badge-danger': data.status == $parent.config.BankCardStatus.REJECT,
                                            'badge-success': data.status == $parent.config.BankCardStatus.APPROVAL
                                          }">
                                    {{ $parent.config.BankCardStatusSummary[data.status] }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">开户名</label>
                            <div class="col-md-9 p-t-7">{{ data.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">银行卡号</label>
                            <div class="col-md-9 p-t-7">{{ data.account }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">银行名</label>
                            <div class="col-md-9 p-t-7">{{ data.bank_name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">开户支行</label>
                            <div class="col-md-9 p-t-7">{{ data.bank_branch }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">备注</label>
                            <div class="col-md-9 p-t-7">{{ data.note }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">绑定时间</label>
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
            this.$root.$on('bankAccountBindInfo.show', data => {
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('bankAccountBindInfo.show')
        }
    }
</script>

