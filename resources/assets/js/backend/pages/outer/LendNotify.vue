<template>
    <li class="dropdown notification-list">
        <a class="nav-link arrow-none waves-effect" :href="link">
            <i class="ti-bell noti-icon"></i>
            <span class="badge badge-pill badge-danger noti-icon-badge">{{ count }}</span>
        </a>
    </li>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        api: "outer",
        mixins: [ReqMixins],
        props: {
            link: {
                type: String,
                required: true
            }
        },
        data: () => ({
            count: 0,
            timer: null
        }),
        methods: {
            async getNotifyCount() {
                this.proccessAjax('lendApplyNotify', {}, res => {
                    this.count = res.data.total
                }, false)
            }
        },
        mounted() {
            this.getNotifyCount()
            this.timer = setInterval(this.getNotifyCount, 10 * 1000)
        },
        destroy() {
            clearInterval(this.timer)
        }
    }
</script>
