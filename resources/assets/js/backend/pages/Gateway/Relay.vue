<template>
    <components :is="paymentHook.component"
                :data="data"
                :expireTime="expireTime"
                :isExpire="isExpire"></components>
</template>

<script>
    import GatewayPaymentType from 'config/GatewayPaymentType'
    import Mixins from './mixins'

    export default {
        api: 'relay',
        mixins: [Mixins],
        components: {
            WeChatPay: () => import('./Relay/WeChatPay'),
            AlipayRedEnvelope: () => import('./Relay/AlipayRedEnvelope'),
            NewBank: () => import('./Relay/NewBank'),
            None: () => import('./Relay/None')
        },
        methods: {
            waitPageReady() {
                setTimeout(() => {
                    if (document.getElementById('page')) {
                        this.showView()
                    } else {
                        this.waitPageReady()
                    }
                }, 200)
            }
        },
        computed: {
            paymentHook() {
                return _(GatewayPaymentType.Hook).getVal(this.data.payment_type, {
                    component: 'None',
                    title: ''
                })
            }
        },
        async mounted() {
            try {
                var res = await this.$callApi(this.apiKey + ':data', {
                    trade_seq: this.trade_seq
                }, null, {isShowAlert: false, throwRes: true})
                this.data = res.data
                this.isExpire = moment.duration(moment(this.data.expired_time).diff(moment())).asSeconds() <= 0
                if (!this.isExpire) {
                    this.counter()
                    this.timer = setInterval(this.counter, 1000)
                }
            } catch (e) {
                console.log(e)
                this.data = e.data
            }
            this.waitPageReady()
            document.title = this.paymentHook.title
        },
        destroyed() {
            clearInterval(this.timer)
        }
    }
</script>
