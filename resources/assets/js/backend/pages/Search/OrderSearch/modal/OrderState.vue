<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">交易状态修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">系統交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_seq }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">商户交易号</label>
                            <div class="col-md-9 p-t-7">{{ data.trade_service_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">金额</label>
                            <div class="col-md-9 p-t-7">{{ data.amount }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">交易状态</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="data.pay_state">
                                    <option v-for="(name, val) in stateList" :key="val" :value="val">{{ name }}</option>
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
    </div><!-- /.modal -->
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        data: () => ({
            stateList: {}
        }),
        methods: {
            onGetState(res) {
                this.data = res.authcode
                this.stateList = res.stateList
            },
            onUpdate() {
                this.updateSuccess()
                $(this.$refs.modal).modal('hide')
            },
            async getState(data) {
                this.proccessAjax('state', data, this.onGetState)
            },
            async update() {
                this.proccessAjax('update', {
                    id: this.data.id,
                    state: this.data.pay_state
                }, this.onUpdate)
            }
        },
        mounted() {
            this.$root.$on('orderState.show', authcode => {
                this.getState({
                    authcode
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('orderState.show')
        }
    }
</script>
