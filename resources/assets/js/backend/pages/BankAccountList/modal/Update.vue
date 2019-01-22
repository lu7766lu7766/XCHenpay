<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">核卡状态</label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline"
                                       v-for="(name, key) in $parent.config.BankCardStatus.updateSummaryMap()"
                                       :key="key">
                                    <input type="radio" :value="key" v-model="data.status"> {{ name }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">备注</label>
                            <div class="col-md-9">
                                <textarea cols="30" rows="5" class="form-control" v-model="data.note"></textarea>
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

    export default {
        mixins: [DetailMixins],
        methods: {
            update() {
                this.proccessAjax('update', _.pick(this.data, ['id', 'status', 'note']), () => {
                    this.updateSuccess()
                    $(this.$refs.modal).modal('hide')
                })
            }
        },
        mounted() {
            this.$root.$on('bankAccountListUpdate.show', data => {
                this.data = _.cloneDeep(data)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('bankAccountListUpdate.show')
        }
    }
</script>

