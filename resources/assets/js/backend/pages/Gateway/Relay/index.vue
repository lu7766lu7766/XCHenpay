<template>
    <components :is="paymentHook.component"
                :data="data"
                :expireTime="expireTime"
                :isExpire="isExpire"
                :tradeSeq="trade_seq"></components>
</template>

<script>
    import Mixins from '../Common/mixins'

    // url: /pay/gateway/relay?trade_seq=xxx
    export default {
        api: 'relay',
        mixins: [Mixins],
        components: {
            WeChatPay: () => import('./WeChatPay'),
            AlipayRedEnvelope: () => import('./AlipayRedEnvelope'),
            NewBank: () => import('./NewBank'),
            HTian: () => import('./HTian'),
            Redirect: () => import('./Redirect'),
            AlipayForwardAlipay: () => import('./AlipayForwardAlipay'),
            Unionpay: () => import('./Unionpay'),
            Post2: () => import('./Post2'),
            None: require('../Common/None')
        }
    }
</script>
