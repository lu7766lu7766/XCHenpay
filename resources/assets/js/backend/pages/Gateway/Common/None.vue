<template>
    <layout :isActive="isActive" :data="data">

        <div slot="miss">
            <img class="warning" src="/gateway/alipay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>

    </layout>
</template>

<script>
    export default {
        props: ['data', 'expireTime'],
        components: {
            layout: require('../Layout')
        },
        computed: {
            isActive() {
                return false
            }
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old2.css';
</style>
