<template>
    <layout :isActive="false" :data="data" v-if="!isActive">
        <div slot="miss">
            <img class="warning" src="/gateway/alipay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>
    </layout>
</template>

<script>
    import {urlParse, formSubmit} from "lib/myLib"

    export default {
        props: ['data', 'expireTime', 'isExpire'],
        components: {
            layout: require('../Layout')
        },
        computed: {
            isActive() {
                return !this.isExpire && this.data.amount
            }
        },
        mounted() {
            if (this.isActive) {
                const res = urlParse(this.data.qrcode_url)
                formSubmit(res.url, res.params)
            }
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old.css';
</style>
