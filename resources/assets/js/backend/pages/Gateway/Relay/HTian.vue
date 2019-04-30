<template>
    <layout :isActive="isActive" :data="data">
        <div slot="help">
            <a href="https://help.alipay.com/lab/help_detail.htm?help_id=258086" class="topbar-link-last"
               target="_blank" seed="goToHelp">常见问题</a>
            <span class="topbar-link-first">你好，欢迎使用支付宝付款！</span>
        </div>

        <div class="qrcode-img-wrapper" id="payok" slot="qrcode-body">
            <div align="center">
                <span id="qrcode">
                    <span id="qrcode_img">
                        <img width="168"
                             :src="data.qrcode_url"/>
                    </span>
                </span>
                <span id="queren"></span>
            </div>
            <div class="qrcode-img-explain fn-clear">

                <slot name="expire"></slot>

            </div>
        </div>

        <div slot="expire">
            <img class="fn-left" src="/gateway/alipay/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
            <div class="fn-left">
                该订单过期还剩<br>
                <strong id="hour_show"><s id="h"></s>{{ expireTime.hours }}时</strong>
                <strong id="minute_show"><s></s>{{ expireTime.minutes }}分</strong>
                <strong id="second_show"><s></s>{{ expireTime.seconds }}秒</strong>
            </div>
        </div>

        <div slot="success">已创建订单，请在手机支付宝上完成付款</div>

        <div slot="step">
            <div class="openalipay">
                <a style="text-decoration:none;">1. 手动截屏二维码<br>2. 开启支付宝扫一扫</a>
            </div>
            <div style="text-align: center">
                <a href="https://mobile.alipay.com/index.htm" target="_blank"
                   class="qrcode-downloadApp">首次使用请下载手机支付宝</a>
            </div>
            <br>
        </div>

        <div slot="tip">
            <img src="/gateway/alipay/T13CpgXf8mXXXXXXXX.png" class="qrguide-area-img active">
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
    export default {
        props: ['data', 'expireTime', 'isExpire'],
        components: {
            layout: require('../Layout')
        },
        computed: {
            isActive() {
                return !this.isExpire && this.data.amount
            }
        }
    }
</script>

<style>
    @import '/gateway/alipay/front-old.css';
</style>
