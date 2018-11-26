<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">管理下发</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">下发帐号</label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline" v-for="(state, key) in options.lendStatus" :key="key">
                                    <input type="radio" :value="key" v-model="data.lend_state">
                                    {{ state }}
                                </label>
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
        data: () => ({
            options: {
                lendStatus: {
                    1: '完成下发',
                    2: '拒绝下发'
                }
            }
        }),
        methods: {
            onUpdate() {
                this.$parent.getList()
                $(this.$refs.modal).modal('hide')
            },
            async update() {
                this.proccessAjax('update', {
                    id: this.data.id,
                    operation: this.data.lend_state
                }, this.onUpdate)
            }
        },
        mounted() {
            this.$root.$on('lendManageState.show', data => {
                this.data = _.cloneDeep(data)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('lendManageState.show')
        }
    }
</script>
