<template>
    <a href="/admin/lendManage">
        <i class="livicon" data-name="bell" data-loop="true" data-color="#e9573f" data-hovercolor="#e9573f"
           data-size="28"></i>
        <span v-if="this.get_lend_apply_total > -1" class="label label-warning">{{ this.get_lend_apply_total }}</span>
    </a>
</template>
<script>
    export default {
        data: () => ({
            datas: []
        }),
        computed: {
            get_lend_apply_total() {
                return this.datas.total ? this.datas.total : 0;
            }
        },
        methods: {
            async fetch() {
                var res = await this.$http.get('/admin/lendManage/applyNotice');
                if (res.ok && res.body.code == 200) {
                    this.datas = res.body.data
                } else {
                    this.datas = [];
                }
            }
        },
        beforeMount() {
            this.fetch()
        }
    }
</script>
