<!DOCTYPE html>
<html lang="zh-Hans-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title')
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    @yield('header')

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
