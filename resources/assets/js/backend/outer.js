var $lendApplyNotifyCount = document.querySelector('#lendApplyNotifyCount')
if ($lendApplyNotifyCount) {
    new Vue({
        el: '#lendApplyNotifyCount',
        template: `<span class="badge badge-pill badge-danger noti-icon-badge">{{ count }}</span>`,
        data: {
            count: 0,
            timer: null
        },
        methods: {
            async getNotifyCount() {
                const res = await this.$callApi('outer:lendApplyNotify')
                this.count = res.data.total
            }
        },
        mounted() {
            this.getNotifyCount()
            this.timer = setInterval(this.getNotifyCount, 10 * 1000)
        },
        destroy() {
            clearInterval(this.timer)
        }
    })
}
