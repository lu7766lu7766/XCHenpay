{{--@if ($errors->any())--}}
    {{--<div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
            {{--<span aria-hidden="true">×</span>--}}
        {{--</button>--}}
        {{--<strong>错误:</strong> {!! dd($errors->messages) !!}--}}
    {{--</div>--}}
{{--@endif--}}

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>成功:</strong> {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>错误:</strong> {{ $message }}
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>警告:</strong> {{ $message }}
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>信息:</strong> {{ $message }}
    </div>
@endif
