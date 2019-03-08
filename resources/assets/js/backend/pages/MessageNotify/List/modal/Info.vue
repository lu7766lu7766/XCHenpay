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
                            <label class="col-md-3 control-label">标题</label>
                            <div class="col-md-9 p-t-7">{{ data.subject }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">类别</label>
                            <div class="col-md-9 p-t-7">
                                <span class="badge badge-pill" v-if="data.category" :class="{
                                        'badge-danger': data.category.code == $parent.config.MessageCategory.SYSTEM,
                                        'badge-success': data.category.code == $parent.config.MessageCategory.FILL_ORDER,
                                        'badge-info': data.category.code == $parent.config.MessageCategory.TRANSACTION,
                                    }">{{ $parent.config.MessageCategorySummary[data.category.code] }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">內容</label>
                            <div class="col-md-9 p-t-7 msg-content">
                                <pre>{{ data.content }}</pre>
                            </div>
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
            this.$root.$on('messageListInfo.show', data => {
                this.data = {}
                this.proccessAjax('info', {id: data.id}, res => {
                    if (!_.has(data, 'seen_by_user.0')) {
                        this.$parent.refresh()
                        this.$bus.emit('getUnreadCount')
                    }
                    this.data = res.data

                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('messageListInfo.show')
        }
    }
</script>

<style scoped>
    .msg-content {
        margin-right: 0;
    }

    .msg-content pre {
        white-space: pre-line;
        font-size: inherit;
        font-family: 'Microsoft JhengHei', "Poppins", sans-serif;
        color: inherit;
    }
</style>
