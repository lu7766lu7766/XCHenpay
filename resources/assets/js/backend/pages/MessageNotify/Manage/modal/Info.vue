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
                            <label class="col-md-3 control-label">发送对象</label>
                            <div class="col-md-9 p-t-7">
                                <span v-for="role in data.role_group"
                                      :key="role.id">
                                    <span class="badge badge-user badge-pill">
                                        {{ role.name }}
                                    </span>&nbsp;
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">內容</label>
                            <div class="col-md-9 p-t-7">
                                {{ data.content }}
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
            this.$root.$on('messageManageInfo.show', data => {
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('messageManageInfo.show')
        }
    }
</script>

