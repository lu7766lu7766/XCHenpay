<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>在线支付 - 网上支付 安全快速！</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    @yield('header')
    <style>
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
</head>

<body>
<div id="loading">
    <div id="loading-text">Loading...</div>
    <div id="loading-content"></div>
</div>
<div id="gateway">
    @yield('content')
</div>

{{--<script src="{{ asset('assets/js/html2canvas.min.js') }}"></script>--}}
{{--<script>--}}
{{--// var saveFile = function (url, filename) {--}}
{{--//     // var save_link = document.createElementNS('http://www.w3.org/1999/xhtml', 'a');--}}
{{--//     // save_link.href = url;--}}
{{--//     // save_link.download = filename;--}}
{{--//     // var event = document.createEvent('MouseEvents');--}}
{{--//     // event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);--}}
{{--//     // save_link.dispatchEvent(event);--}}
{{--//     var a = document.createElement('a')--}}
{{--//     a.href = url--}}
{{--//     a.download = filename // 'image.png';--}}
{{--//     a.click()--}}
{{--// }--}}
{{--// var url2Download = function (url, filename) {--}}
{{--//     var type = 'png';--}}
{{--//     var imgData = url // $(".htmlimg").attr("src");--}}
{{--//     var _fixType = function (type) {--}}
{{--//         type = type.toLowerCase().replace(/jpg/i, 'jpeg');--}}
{{--//         var r = type.match(/png|jpeg|bmp|gif/)[0];--}}
{{--//         return 'image/' + r;--}}
{{--//     };--}}
{{--//     imgData = imgData.replace(_fixType(type), 'image/octet-stream'); // application/octet-stream--}}
{{--//     filename = filename + '.' + type;--}}
{{--//     saveFile(imgData, filename);--}}
{{--// }--}}
{{--// var screenshot = function (filename) {--}}
{{--//     var w = window.outerWidth // $(window).width();--}}
{{--//     var h = window.outerHeight // $(window).height();--}}
{{--//     var canvas = document.createElement("canvas");--}}
{{--//     // canvas.width = w;--}}
{{--//     // canvas.height = h;--}}
{{--//     // canvas.style.width = w + "px";--}}
{{--//     // canvas.style.height = h + "px";--}}
{{--//     // var context = canvas.getContext("2d");--}}
{{--//     // context.scale(2, 2);--}}
{{--//     html2canvas(document.body, {--}}
{{--//         canvas: canvas,--}}
{{--//         logging: false,--}}
{{--//         width: w, // 如要擷取螢幕以外的部分請移除--}}
{{--//         height: h,  // 如要擷取螢幕以外的部分請移除--}}
{{--//     }).then(function (canvas) {--}}
{{--//         // saveFile(canvas.toDataURL('png'), filename + '.png')--}}
{{--//         url2Download(canvas.toDataURL('png'), filename)--}}
{{--//     });--}}
{{--// }--}}

{{--</script>--}}
<script src="{{ asset('assets/js/View.js') }}"></script>

</body>
</html>
