<template>
    <components :is="paymentHook.component"
                :data="data"
                :expireTime="expireTime"
                :isExpire="isExpire"
                :tradeSeq="trade_seq"></components>
</template>

<script>
    import Mixins from '../Common/mixins'

    export default {
        api: 'select',
        mixins: [Mixins],
        components: {
            Alipay: require('./Alipay'),
            None: require('../Common/None')
        }
    }
</script>

