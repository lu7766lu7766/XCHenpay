<template>
    <section>
        <div id="page">
            <div class="topbar">
                <div class="topbar-wrap fn-clear">

                    <slot name="help"></slot>

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
                            <div class="cashier-center-view view-qrcode fn-left my-qrcode-style" id="J_view_qr"
                                 style="postion:relative;left:40px;"
                                 v-if="isActive">
                                <!-- 扫码区域 -->
                                <div data-role="qrPayArea" class="qrcode-integration qrcode-area" id="J_qrPayArea">

                                    <slot name="qrcode-header"></slot>

                                    <slot name="qrcode-body">
                                        <div class="qrcode-img-wrapper" id="payok">
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
                                    </slot>

                                    <slot name="redirect_btn"></slot>
                                    <div id="qrPayScanSuccess"
                                         class="mi-notice mi-notice-success  qrcode-notice fn-hide"
                                         style="display: none;margin-top: 5px;">
                                        <div class="mi-notice-cnt">
                                            <div class="mi-notice-title qrcode-notice-title">
                                                <i class="iconfont qrcode-notice-iconfont" title="扫描成功"></i>
                                                <p class="mi-notice-explain-other qrcode-notice-explain ft-break">
                                                    <span class="ft-orange fn-mr5" data-role="qrPayAccount"></span>
                                                    <slot name="success"></slot>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <slot name="step"></slot>

                                </div>
                                <!-- 指引区域 -->
                                <div class="qrguide-area">

                                    <slot name="tip"></slot>

                                </div>
                            </div>
                            <!-- 已過期 --->
                            <div class="cashier-center-view view-qrcode"
                                 v-else>
                                <div class="miss">

                                    <slot name="miss"></slot>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="partner"><br>
                <slot name="partner"></slot>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        api: 'alipay',
        props: ['isActive', 'data'],
        components: {
            qrcode: require('@chenfengyuan/vue-qrcode').default
        },
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
