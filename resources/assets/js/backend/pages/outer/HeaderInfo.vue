<template>
    <li class="dropdown notification-list">
        <div class="dropdown today-box">
            <a class="nav-link arrow-none ip">
                <span>
                    <i class="ti-server noti-icon"></i>
                    <span>IP: {{ ip }}</span>
                </span>
            </a>
            <a class="nav-link arrow-none pc-today-list">
                <span>
                    <i class="ti-check-box noti-icon"></i>
                    <span>交易成功: {{ totalMoney | numFormat('0,0.000') }}</span>
                </span>
                <span>
                    <i class="ti-timer noti-icon"></i>
                    <span>手续费: {{ totalFee | numFormat('0,0.000') }}</span>
                </span>
                <span>
                    <i class="ti-clipboard noti-icon"></i>
                    <span>笔数: {{ totalNum }}</span>
                </span>
            </a>
        </div>
    </li>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        api: "outer",
        mixins: [ReqMixins],
        data: () => ({
            ip: '',
            totalFee: 0,
            totalMoney: 0,
            totalNum: 0
        }),
        methods: {
            getData() {
                this.proccessAjax('headerInfo', {}, res => {
                    _.assign(this, res.data)
                }, false)
            }
        },
        mounted() {
            this.getData()
        }
    }
</script>
