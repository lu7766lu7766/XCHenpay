<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>龙亨支付</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico')}}">

    <!-- datapicker style -->
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Sweet Alert -->
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

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

        .monitor_ex .container {
            padding: 30px;
            background-color: #fff;
        }

    </style>
</head>

<body>
<header>
    <div class="container text-center">
        监听格式填写说明
    </div>
</header>
<div class="monitor_ex">
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-box">
                <thead>
                <tr>
                    <th colspan="2">范例</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="130">简讯文字</td>
                    <td>[邮储银行] 19年03月14日22:00郑志平帐户6015向您尾号485帐号他行来帐金额1000.00元，余额308544.30元</td>
                </tr>
                <tr>
                    <td>监听格式</td>
                    <td>[邮储银行] {year}年{month}月{date}日{hour}:{minute} {who}帐户
                        {who_number}向您尾号{my_number}帐号他行来帐金额{amount}元，余额{any_amount}元
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive m-t-15">
            <table class="table table-hover table-bordered table-box">
                <thead>
                <tr>
                    <th width="130">对应</th>
                    <th>说明</th>
                    <th>范例</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{myself}</td>
                    <td>收款人</td>
                    <td>陈忠根</td>
                </tr>
                <tr>
                    <td>{who}</td>
                    <td>付款人</td>
                    <td>郑志平</td>
                </tr>
                <tr>
                    <td>{my_number}</td>
                    <td>收款人的卡号(或尾码)</td>
                    <td>4855</td>
                </tr>
                <tr>
                    <td>{who_number}</td>
                    <td>付款人的卡号(或尾码)</td>
                    <td>6015</td>
                </tr>
                <tr>
                    <td>{year}</td>
                    <td>交易时间的「年」</td>
                    <td>19</td>
                </tr>
                <tr>
                    <td>{month}</td>
                    <td>交易时间的「月」</td>
                    <td>03</td>
                </tr>
                <tr>
                    <td>{date}</td>
                    <td>交易时间的「日」</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>{hour}</td>
                    <td>交易时间的「时」</td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>{minute}</td>
                    <td>交易时间的「分」</td>
                    <td>00</td>
                </tr>
                <tr>
                    <td>{second}</td>
                    <td>交易时间的「秒」</td>
                    <td>00</td>
                </tr>
                <tr>
                    <td>{any_time}</td>
                    <td>非交易时间的「年/月/日/时/分/秒」</td>
                    <td>00</td>
                </tr>
                <tr>
                    <td>{amount}</td>
                    <td>交易金额</td>
                    <td>1000.00</td>
                </tr>
                <tr>
                    <td>{any_amount}</td>
                    <td>非交易金额，例如余额</td>
                    <td>307777.50</td>
                </tr>
                <tr>
                    <td>{any_text}</td>
                    <td>非上述的任意文字</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- end step-list -->
<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/waves.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- datapicker js -->
<script src="{{ asset('plugins/datepicker/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('plugins/datepicker/js/bootstrap-datetimepicker.zh-CN.js') }}"></script>

<!-- Sweet-Alert  -->
<script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

<!-- Magnific popup -->
<script src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(function () {
        $('.zoom-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
                verticalFit: true,
                titleSrc: function (item) {
                    // return item.el.attr('title') + ' &middot; <a href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
                }
            },
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300, // don't foget to change the duration also in CSS
                opener: function (element) {
                    return element.find('img');
                }
            }
        });
    })
</script>
</body>
</html>
