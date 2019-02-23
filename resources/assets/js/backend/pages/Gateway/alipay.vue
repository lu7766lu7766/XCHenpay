<template>
    <section>
        <div id="loading">
            <div id="loading-text">Loading...</div>
            <div id="loading-content"></div>
        </div>
        <div id="page">
            <div class="topbar">
                <div class="topbar-wrap fn-clear">
                    <a href="https://help.alipay.com/lab/help_detail.htm?help_id=258086" class="topbar-link-last"
                       target="_blank" seed="goToHelp">常见问题</a>
                    <span class="topbar-link-first">你好，欢迎使用支付宝付款！</span>
                </div>
            </div>
            <div id="header">
                <div class="header-container fn-clear">
                    <div class="header-title">
                        <div class="alipay-logo">
                        </div>
                        <span class="logo-title">
                            我的收银台
                        </span>
                    </div>
                </div>
            </div>
            <div id="container">
                <div id="content" class="fn-clear">
                    <div id="J_order" class="order-area">
                        <div id="order" class="order order-bow">
                            <div class="orderDetail-base">
                                <div class="commodity-message-row">
                                    交易单号：{{ data.order_number }}
                                    <t v-if="isActive">(该订单有效期为5分钟，过期后请不要支付。)</t>
                                </div>
                                <span class="payAmount-area" id="J_basePriceArea">
                                    <strong class=" amount-font-22 ">
                                        {{ data.amount | numFormat('0,0.00') }}
                                    </strong>元
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- 操作区 -->
                    <div class="cashier-center-container">
                        <div data-module="excashier/login/2015.08.02/loginPwdMemberT" id="J_loginPwdMemberTModule"
                             class="cashiser-switch-wrapper fn-clear">

                            <!-- 扫码支付页面 -->
                            <div class="cashier-center-view view-qrcode fn-left" id="J_view_qr"
                                 style="postion:relative;left:40px;" v-if="isActive">
                                <!-- 扫码区域 -->
                                <div data-role="qrPayArea" class="qrcode-integration qrcode-area" id="J_qrPayArea">
                                    <div class="qrcode-header">
                                        <div class="ft-center">
                                            扫一扫付款（元）
                                        </div>
                                        <div class="ft-center qrcode-header-money">
                                            {{ data.amount | numFormat('0,0.00') }}
                                        </div>
                                    </div>
                                    <div class="qrcode-img-wrapper" id="payok">
                                        <div align="center">
                                            <span id="qrcode">
                                                <span id="qrcode_img">
                                                    <qrcode :value="data.qrcode_url" :options="{
                                                        width: 168,
                                                        margin: 0
                                                    }"></qrcode>
                                                </span>
                                            </span>
                                            <span id="queren"></span>
                                        </div>
                                        <div class="qrcode-img-explain fn-clear">
                                            <img class="fn-left" src="/gateway/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
                                            <div class="fn-left">
                                                该订单过期还剩<br>
                                                <strong id="hour_show"><s id="h"></s>{{ expireTime.hours }}时</strong>
                                                <strong id="minute_show"><s></s>{{ expireTime.minutes }}分</strong>
                                                <strong id="second_show"><s></s>{{ expireTime.seconds }}秒</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="qrPayScanSuccess"
                                         class="mi-notice mi-notice-success  qrcode-notice fn-hide"
                                         style="display: none;margin-top: 5px;">
                                        <div class="mi-notice-cnt">
                                            <div class="mi-notice-title qrcode-notice-title">
                                                <i class="iconfont qrcode-notice-iconfont" title="扫描成功"></i>
                                                <p class="mi-notice-explain-other qrcode-notice-explain ft-break">
                                                    <span class="ft-orange fn-mr5" data-role="qrPayAccount"></span>
                                                    已创建订单，请在手机支付宝上完成付款
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="openalipay">
                                        <!--href="alipayqr://platformapi/startapp?saId=10000007"-->
                                        <a style="text-decoration:none;">1. 手动截屏二维码<br>2. 开启支付宝扫一扫</a>
                                    </div>
                                    <div style="text-align: center">
                                        <a href="https://mobile.alipay.com/index.htm" target="_blank"
                                           class="qrcode-downloadApp">首次使用请下载手机支付宝</a>
                                    </div>
                                    <br><br>
                                </div>
                                <!-- 指引区域 -->
                                <div class="qrguide-area">
                                    <img src="/gateway/T13CpgXf8mXXXXXXXX.png" class="qrguide-area-img active"></div>
                            </div>
                            <!-- 已過期 --->
                            <div class="cashier-center-view view-qrcode fn-left"
                                 style="postion:relative;left:40px;text-align:center; top:50px;"
                                 v-else>
                                <div class="ft-center qrcode-header-money">
                                    {{ data.msg }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="partner"><br>
                <p>本站为第三方辅助软件服务商，与支付宝官方和淘宝网无任何关系<br>支付系统 不提供资金托管和结算，转账后将立即到达指定的账户。</p>
                <br><img alt="合作机构" src="/gateway/2R3cKfrKqS.png"></div>
        </div>
    </section>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        api: 'alipay',
        props: ['trade_seq'],
        mixins: [ReqMixins],
        components: {
            qrcode: require('@chenfengyuan/vue-qrcode').default
        },
        data: () => ({
            isActive: false,
            data: {},
            timer: null,
            expireTime: {
                hours: 0,
                minutes: 0,
                seconds: 0,
                totalSeconds: 0
            },
        }),
        watch: {
            'expireTime.totalSeconds'(sec) {
                if (sec <= 0) {
                    location.reload()
                }
            }
        },
        methods: {
            show(id, value) {
                document.getElementById(id).style.display = value ? 'block' : 'none'
            },
            showView() {
                this.show('page', true)
                this.show('loading', false)
            },
            counter() {
                const diffMoment = moment(moment(this.data.expired_time)).diff(moment())
                const durationMoment = moment.duration(diffMoment)
                this.expireTime.hours = this.data.expired_time ? durationMoment.hours() : 0
                this.expireTime.minutes = this.data.expired_time ? durationMoment.minutes() : 0
                this.expireTime.seconds = this.data.expired_time ? durationMoment.seconds() : 0
                this.expireTime.totalSeconds = this.data.expired_time ? durationMoment.asSeconds() : 0
            }
        },
        async mounted() {
            try {
                var res = await this.$callApi(this.apiKey + ':data', {
                    trade_seq: this.trade_seq
                }, null, {isShowAlert: false, throwRes: true})
                this.showView()
                this.isActive = true
                this.data = res.data
                this.counter()
                this.timer = setInterval(this.counter, 1000)
                // this.$nextTick(() => {
                //     window.screenshot(this.data.order_number)
                // })
            } catch (e) {
                this.data = e.data
                this.showView()
            }
        },
        destroyed() {
            clearInterval(this.timer)
        }
    }
</script>

<style>
    body {
        font-family: 微软雅黑;
    }

    #page {
        display: none;
    }

    #loading {
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    #loading-text {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        color: #d8d8d8;
        width: 100px;
        height: 30px;
        margin: -7px 0 0 -45px;
        text-align: center;
        font-family: 'PT Sans Narrow', sans-serif;
        font-size: 18px;
    }

    #loading-content {
        display: block;
        position: relative;
        left: 50%;
        top: 50%;
        width: 170px;
        height: 170px;
        margin: -85px 0 0 -85px;
        border: 3px solid #F00;
    }

    #loading-content:after {
        content: "";
        position: absolute;
        border: 3px solid #0F0;
        left: 15px;
        right: 15px;
        top: 15px;
        bottom: 15px;
    }

    #loading-content:before {
        content: "";
        position: absolute;
        border: 3px solid #00F;
        left: 5px;
        right: 5px;
        top: 5px;
        bottom: 5px;
    }

    #loading-content {
        border: 3px solid transparent;
        border-top-color: #71a2f5;
        border-bottom-color: #71a2f5;
        border-radius: 50%;
        -webkit-animation: loader 2s linear infinite;
        -moz-animation: loader 2s linear infinite;
        -o-animation: loader 2s linear infinite;
        animation: loader 2s linear infinite;
    }

    #loading-content:before {
        border: 3px solid transparent;
        border-top-color: #f3e974;
        border-bottom-color: #f3e974;
        border-radius: 50%;
        -webkit-animation: loader 3s linear infinite;
        -moz-animation: loader 2s linear infinite;
        -o-animation: loader 2s linear infinite;
        animation: loader 3s linear infinite;
    }

    #loading-content:after {
        border: 3px solid transparent;
        border-top-color: #4fd893;
        border-bottom-color: #4fd893;
        border-radius: 50%;
        -webkit-animation: loader 1.5s linear infinite;
        animation: loader 1.5s linear infinite;
        -moz-animation: loader 2s linear infinite;
        -o-animation: loader 2s linear infinite;
    }

    @-webkit-keyframes loaders {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes loader {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
