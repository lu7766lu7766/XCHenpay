<template>
    <layout :isActive="isActive" :data="data">
        <div slot="help">
            <a href="https://help.alipay.com/lab/help_detail.htm?help_id=258086" class="topbar-link-last"
               target="_blank" seed="goToHelp">常见问题</a>
            <span class="topbar-link-first">你好，欢迎使用支付宝付款！</span>
        </div>

        <div slot="qrcode-body">
            <div data-role="qrPayArea" class="qrcode-integration qrcode-area" id="J_qrPayArea">
                <div class="aplogo"><img src="/gateway/alipay/aplogo.png" alt=""></div>
                <div class="text-center">
                    <button class="btn-open" type="button" @click="linkTo('alipay')">
                        点击唤起支付宝
                    </button>
                </div>
                <div class="openalipay">使用支付宝支付需要等待120秒</div>
                <a href="https://mobile.alipay.com/index.htm" target="_blank"
                   class="qrcode-downloadApp">首次使用请下载手机支付宝</a>
            </div>

            <div data-role="qrPayArea" class="qrcode-integration qrcode-area" id="J_qrPayArea">
                <div class="tblogo"><img src="/gateway/alipay/tblogo.png" alt=""></div>
                <div class="text-center">
                    <button class="btn-open2" type="button" @click="linkTo('taobo')">
                        点击唤起淘宝
                    </button>
                </div>
                <div class="openalipay">透过淘宝跳转可直接支付</div>
                <a href="https://mpage.taobao.com/hd/download.html?TBG=146112.176505.4&spm=1.146112.176505.4"
                   target="_blank" class="qrcode-downloadApp">首次使用请下载手机淘宝</a>　　 　
            </div>
        </div>

        <div slot="miss">
            <img class="warning" src="/gateway/alipay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>

        <div slot="partner">
            <br>
            <p>本站为第三方辅助软件服务商，与支付宝官方和淘宝网无任何关系<br>支付系统 不提供资金托管和结算，转账后将立即到达指定的账户。</p>
            <br><img alt="合作机构" src="/gateway/alipay/2R3cKfrKqS.png">
        </div>
    </layout>
</template>

<script>
    import {getUrlParameter} from 'lib/myLib'
    import ReqMixins from 'mixins/request'

    export default {
        props: ['data', 'expireTime', 'isExpire', 'tradeSeq'],
        mixins: [ReqMixins],
        components: {
            layout: require('../Layout')
        },
        methods: {
            waiter(times) {
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve(1)
                    }, times * 1000)
                })
            },
            async getUrl(key) {
                const res = await this.$callApi(this.apiKey + ':' + key, {
                    trade_seq: this.tradeSeq
                })
                return res.data
            },
            async linkTo(key) {
                const url = await this.getUrl(key)
                location.href = url
            }
        },
        computed: {
            isActive() {
                return !this.isExpire && !!this.data.amount
            }
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old2.css';
</style>
