<template>
    <layout :isActive="false" :data="data" v-show="!!firstWaitSecs">
        <div slot="miss" v-if="!isExpire && !isNone">
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
    import Mixins from '../Common/mixins'
    import {getUrlParameter} from 'lib/myLib'

    export default {
        api: 'select',
        mixins: [Mixins],
        components: {
            layout: require('../Layout')
        },
        watch: {
            async data() {
                await this.waiter()
                this.data && this.data.qrcode_url && (location.href = this.data.qrcode_url)
            }
        },
        data: () => ({
            timer: null,
            firstWaitSecs: 0,
            waitSecs: 0
        }),
        methods: {
            // 複寫掉，讓他永遠不會因為過期而取消頁面
            counter() {
            },
            waiter() {
                return new Promise(resolve => {
                    this.timer = setInterval(() => {
                        if (!this.waitSecs || !--this.waitSecs) {
                            this.waitSecs = 0
                            clearInterval(this.timer)
                            resolve(1)
                        }
                    }, 1000)
                })
            }
        },
        mounted() {
            this.waitSecs = this.firstWaitSecs = getUrlParameter('wait') ? getUrlParameter('wait') : 0
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old.css';
</style>
