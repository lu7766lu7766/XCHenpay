<template>
    <div ref="modal" class="modal fade modal-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">API编号</label>
                            <div class="col-md-9 p-t-7">{{ data.i6pay_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">通道名称</label>
                            <div class="col-md-9 p-t-7">{{ data.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">手续费率</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" placeholder="1.50" v-model="data.fee">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline"
                                       v-for="(status, index) in $parent.options.status"
                                       :key="index">
                                    <input type="radio" :value="status.val" v-model="data.status">{{ status.name }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-9 p-t-7">{{ data.description }}</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="update">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        methods: {
            update() {
                this.proccessAjax('update', {
                    status: this.data.status,
                    id: this.data.id,
                    merchant_id: this.$parent.company_id,
                    fee: this.data.fee
                }, _ => {
                    this.updateSuccess()
                    $(this.$refs.modal).modal('hide')
                })
            },
            hasCustom(data) {
                data.fee = data.payment_fee[0].fee
                data.status = data.payment_fee[0].status
            },
            nonCustom(data) {
                data.fee = data.fee
                data.status = data.activate
            }
        },
        mounted() {
            this.$root.$on('feeManageEdit.show', data => {
                data = _.cloneDeep(data)
                data.payment_fee && data.payment_fee[0]
                    ? this.hasCustom(data)
                    : this.nonCustom(data)
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('feeManageEdit.show')
        }
    }
</script>
