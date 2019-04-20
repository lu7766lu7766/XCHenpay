<template>
    <layout :isActive="false" :data="data" v-if="!isActive">
        <div slot="miss">
            <img class="warning" src="/gateway/alipay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>
    </layout>
</template>

<script>
    export default {
        props: ['data', 'expireTime', 'isExpire'],
        computed: {
            isActive() {
                return !this.isExpire && this.data.amount
            }
        },
        mounted() {
            if (this.isActive) {
                location.href = this.data.qrcode_url
            }
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old.css';
</style>
