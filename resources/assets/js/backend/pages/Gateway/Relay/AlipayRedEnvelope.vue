<template>
    <layout :isActive="isActive" :data="data">

        <div slot="miss" v-if="!isExpire">
            <img class="warning" src="/gateway/alipay/arouse.png" alt="">
            支付宝APP唤起中, 请稍候...{{ waitSecs }}秒
        </div>

        <div slot="miss" v-else>
            <img class="warning" src="/gateway/alipay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>

    </layout>
</template>

<script>
    export default {
        props: ['data', 'expireTime', 'isExpire'],
        components: {
            layout: require('../Layout')
        },
        data: () => ({
            timer: null,
            waitSecs: 60
        }),
        methods: {
            addFriend() {
                ap.pushWindow({
                    url: this.data.friend_url
                })
                // window.open('')
            },
            redirect() {
                ap.redirectTo({
                    url: this.data.qrcode_url
                })
            },
            counter() {
                this.waitSecs = --this.waitSecs < 0 ? 0 : this.waitSecs
                if (!this.waitSecs) {
                    this.redirect()
                    clearInterval(this.timer)
                }
            }
        },
        computed: {
            isActive() {
                return false
            }
        },
        mounted() {
            if (!this.isExpire) {
                this.addFriend()
                this.timer = setInterval(this.counter, 1000)
            }
        },
        destroyed() {
            clearInterval(this.timer)
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old.css';
</style>
