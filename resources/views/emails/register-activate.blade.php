@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => ''])
@lang('general.app_name')
@endcomponent
@endslot

# {!! $user->full_name !!} 您好：<br>

欢迎来到 @lang('general.app_name')！<br>

点击下方按钮链结来前往 @lang('general.app_name')<br>

这里是您的登入资讯，，登入后请您尽快更改您的登入密码<br>

- 帐号: {!! $user->username !!}
- 密码: {!! $user->password !!}

@component('mail::button', ['url' =>  $user->activationUrl])
@lang('general.app_name')
@endcomponent

@lang('general.app_name') 感谢您

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
&copy; 2018 All Copy right received
@endcomponent
@endslot
@endcomponent