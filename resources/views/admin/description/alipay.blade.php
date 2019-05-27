<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>龙亨支付</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- datapicker style -->
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Sweet Alert -->
{{--<link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">--}}

<!-- Magnific popup -->
    <link href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css">

    <!-- default style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <!-- myself style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-size: 15px;
            padding-bottom: 0;
            font-family: 'Microsoft JhengHei', 'Helvetica Neue', sans-serif;
            padding-top: 57px;
        }

        .container {
            max-width: 900px;
        }

        img {
            width: 600px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        header {
            background-color: #2a3142;
            color: #fff;
            font-size: 25px;
            padding: 10px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
        }

        .step-list .container {
            padding: 30px;
            background-color: #fff;
        }

        .step-item {
            margin-bottom: 25px;
        }

        .step-item li {
            word-break: break-all;
        }

        .step-title {
            font-size: 20px;
            color: #3eb7ba;
            margin-bottom: 10px;
        }

        .step-txt ol {
            margin-left: 15px;
            padding-left: 0;
        }

        .mfp-title {
            display: none;
        }

        @media (max-width: 767px) {
            img {
                width: 80%;
            }

            img.mfp-img {
                max-width: 90%;
            }
        }

        @media (max-width: 575px) {
            body {
                padding-top: 50px;
            }

            header {
                font-size: 20px;
            }

            .step-list .container {
                padding: 20px;
            }

            .step-title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
<header>
    <div class="container text-center">
        获取银行卡隐藏cardid教程
    </div>
</header>
<div class="step-list">
    <div class="container">
        <div class="step-item">
            <div class="step-title">第一步：<span>转账</span></div>
            <div class="step-txt">
                <ol>
                    <li>使用 支付宝银行卡转账功能 给即将要添加的银行卡转账一笔金额，金额不限制。</li>
                    <li>转账之后，就会有转账记录，才能有接下来的操作。</li>
                </ol>
            </div>
        </div>
        <div class="step-item">
            <div class="step-title">第二步：<span>获取 cardid</span></div>
            <div class="step-txt">
                <ol>
                    <li>浏览器打开网址 <a href="https://shenghuo.alipay.com/transfercore/fill.htm?_tosheet=true"
                                   target="_blank" class="text-blue">https://shenghuo.alipay.com/transfercore/fill.htm?_tosheet=true</a>
                        支付宝扫码登录
                    </li>
                    <li class="zoom-gallery">登录成功会出现如下界面<br/><a href="{{ asset('img/alipay-img1.png') }}"><img
                                    src="{{ asset('img/alipay-img1.png') }}" alt=""></a></li>
                    <li class="zoom-gallery">如下图，点击<b class="text-blue">已存银行卡</b>按钮，出现转账记录下拉框<br/><a
                                href="{{ asset('img/alipay-img2.png') }}"><img src="{{ asset('img/alipay-img2.png') }}"
                                                                               alt=""></a></li>
                    <li class="zoom-gallery">
                        右击银行卡选择检查（google浏览器点击<b>检查</b>，360浏览器点击<b>审查元素</b>），查看右边出现的信息，找到对应银行卡的对应的<b>cardid</b>（如1901091848198019490），请参考下图。<br/><a
                                href="{{ asset('img/alipay-img3.png') }}"><img src="{{ asset('img/alipay-img3.png') }}"
                                                                               alt=""></a></li>
                </ol>
            </div>
        </div>
        <div class="step-item">
            <div class="step-title">第三步</div>
            <div class="step-txt">
                <ol>
                    <li>把以上获取的 cardid，复制到后台对应位置（<span class="text-red">特别注意，检查复制的内容不要带空格</span>），完成。</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end step-list -->
<!-- jQuery  -->
{{--<script src="{{ asset('assets/js/jquery.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/waves.min.js') }}"></script>--}}

{{--<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>--}}

<!-- datapicker js -->
{{--<script src="{{ asset('plugins/datepicker/js/moment.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>--}}
{{--<script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.zh-CN.js') }}"></script>--}}

<!-- Sweet-Alert  -->
{{--<script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>--}}

<!-- Magnific popup -->
{{--<script src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>--}}

<!-- App js -->
{{--<script src="{{ asset('assets/js/app.js') }}"></script>--}}
<script>
    // $(function () {
    //     $('.zoom-gallery').magnificPopup({
    //         delegate: 'a',
    //         type: 'image',
    //         closeOnContentClick: false,
    //         closeBtnInside: false,
    //         mainClass: 'mfp-with-zoom mfp-img-mobile',
    //         image: {
    //             verticalFit: true,
    //             titleSrc: function (item) {
    //                 // return item.el.attr('title') + ' &middot; <a href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
    //             }
    //         },
    //         gallery: {
    //             enabled: true
    //         },
    //         zoom: {
    //             enabled: true,
    //             duration: 300, // don't foget to change the duration also in CSS
    //             opener: function (element) {
    //                 return element.find('img');
    //             }
    //         }
    //     });
    // })
</script>
</body>
</html>
