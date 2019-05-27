<template>
    <layout :isActive="isActive" :data="data">
        <div slot="help">
            <a href="https://static.95516.com/static/help/detail_243.html" class="topbar-link-last" target="_blank"
               seed="goToHelp">常见问题</a>
            <span class="topbar-link-first">你好，欢迎使用云闪付付款！</span>
        </div>

        <div slot="qrcode-header">
            <div class="qrcode-header">
                <div class="BankCard">
                    <input type="text" maxlength="4" id="BankCard" name="BankCard" placeholder="卡号後四位"
                           v-model="search.account">
                    <button class="btn-submit" type="button" @click="checkCanShowQRCode()">送出</button>
                    <br>
                    <br>
                    <label for="BankCard">「请确实填写, 会影响您入款时的效率」</label>
                </div>
            </div>
        </div>

        <div slot="qrcode-body">
            <div class="qrcode-img-wrapper" id="payok" v-if="isShowQRCode">
                <div align="center">
                <span id="qrcode">
                    <span id="qrcode_img">
                        <qrcode :value="data.qrcode_url"
                                :options="{
                                width: 168,
                                margin: 0
                            }">
                        </qrcode>
                    </span>
                </span>
                    <span id="queren"></span>
                </div>
                <div class="qrcode-img-explain fn-clear">

                    <slot name="expire"></slot>

                </div>
            </div>
        </div>


        <div slot="expire">
            <img class="fn-left" src="/gateway/unionpay/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
            <div class="fn-left">
                该订单过期还剩<br>
                <strong id="hour_show"><s id="h"></s>{{ expireTime.hours }}时</strong>
                <strong id="minute_show"><s></s>{{ expireTime.minutes }}分</strong>
                <strong id="second_show"><s></s>{{ expireTime.seconds }}秒</strong>
            </div>
        </div>

        <!--<div slot="redirect_btn" >-->
        <!--<div class="text-center">-->
        <!--<button class="btn-open" type="button">点击唤起云闪付</button>-->
        <!--</div>-->
        <!--</div>-->

        <div slot="success">已创建订单，请在手机支付宝上完成付款</div>

        <div slot="step" v-if="isShowQRCode">
            <div class="openalipay">
                <a style="text-decoration:none;">1. 手动截屏二维码<br>2. 开启云闪付扫一扫</a>
            </div>
            <div style="text-align: center">
                <a href="http://static.95516.com/static/phone/index.html" target="_blank" class="qrcode-downloadApp">
                    首次使用请下载手机云闪付</a>
            </div>
            <br>
        </div>

        <img slot="tip" v-if="isShowQRCode" src="/gateway/unionpay/T13CpgXf8mXXXXXXXX.png"
             class="qrguide-area-img active">

        <div slot="miss">
            <img class="warning" src="/gateway/unionpay/warning.png" alt="">
            订单不存在或已经过期<br>请重新发起支付
        </div>

        <div slot="partner">
            <br>
            <p>本站为第三方辅助软件服务商，与支付宝官方和淘宝网无任何关系<br>支付系统 不提供资金托管和结算，转账后将立即到达指定的账户。</p>
            <br><img alt="合作机构" src="/gateway/unionpay/2R3cKfrKqS.png">
        </div>
    </layout>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        props: ['data', 'expireTime', 'isExpire', 'tradeSeq'],
        mixins: [ReqMixins],
        rules: {
            'search.account': {
                'number': {
                    message: '卡号型态不符'
                },
                'len': {
                    value: 4,
                    message: '卡号长度不符'
                }
            }
        },
        components: {
            layout: require('../Layout'),
            qrcode: require('@chenfengyuan/vue-qrcode').default
        },
        data: () => ({
            isShowQRCode: false,
            search: {
                account: ''
            }
        }),
        methods: {
            checkCanShowQRCode() {
                try {
                    this.validate();
                } catch (e) {
                    return alert(e);
                }
                this.callApi(async () => {
                    const res = await this.$api.gateway.relay.getInfo({
                        trade_seq: this.tradeSeq,
                        account: this.search.account
                    })
                    if (res.data.result) {
                        this.isShowQRCode = true
                    }
                })
            }
        },
        computed: {
            isActive() {
                return !this.isExpire && this.data.amount
            }
        }
    }
</script>

<style scoped>
    @import '/gateway/unionpay/front-old.css';

    .qrguide-area-img {
        top: 110px;
    }

    @media screen and (max-width: 760px) {
        .qrguide-area-img {
            top: 180px;
        }
    }

</style>
