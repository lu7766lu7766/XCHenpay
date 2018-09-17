@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    权限设置
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/iCheck/css/all.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/pages/mail_box.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"/>
    <style>
        .table tbody td:first-child {
            text-align: center;
        }
        .whitebg {
            border: none;
        }
    </style>
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <!--section starts-->
        <h1>权限设置</h1>

        <ol class="breadcrumb">
            <i class="livicon" data-name="key" data-size="14" data-loop="true"></i>
            <li class="active">
                权限设置
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="row web-mail">
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="whitebg">
                    <ul class="pmMenu">
                        @foreach($roles as $r)
                            <li>
                                <a href="javascript:void(0);" class="rolesSelect" data-role="{{ $r->id }}">
                                    <i class="livicon" data-n="user" data-s="16" data-c="gray"></i> &nbsp; &nbsp; {{ $r->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8">
                <div class="whitebg">
                    @foreach($roles as $r)
                    <table class="table table-striped table-advance table-hover setting-table" data-table="{{ $r->id }}" style="display: none;">
                        <thead>
                            <tr>
                                <td colspan="6">
                                    <div class="col-md-8">
                                        <h4>
                                            <strong>权限开关</strong>
                                        </h4>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($r->permissions as $pKey => $pValue)
                                <tr>
                                    <td style="width:10%;" class="inbox-small-cells">
                                        <span>
                                            <input type="checkbox" name="pm-switch" data-size="mini"
                                                   data-key="{{ $pKey }}" @if($pValue) checked @endif>
                                        </span>
                                    </td>
                                    <td style="width:80%;" class="view-message">
                                        <div class="col-md-12">
                                            {{ $pKey }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script>
        var swBtn = $("[name='pm-switch']");
        swBtn.bootstrapSwitch();
        swBtn.on('switchChange.bootstrapSwitch', function (event, state) {
            let id = $(event.currentTarget).parents('table').data('table');
            let key = $(event.currentTarget).data('key');

            $.ajax({
                type: "POST",
                url: '{!! route('admin.permission.update') !!}',
                dataType: "json",
                data: {
                    id: id,
                    key: key,
                    state: state
                },
                success: function(data) {
                    console.log(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr, ajaxOptions, thrownError);
                }
            });
        });

        $('.rolesSelect').click(function () {
            let id = $(this).data('role');
            $('.pmMenu li').removeClass('active');
            $(this).parent().addClass('active');
            $('.setting-table').hide();
            $('.setting-table[data-table="' + id + '"]').stop().fadeIn();
        });
    </script>
@stop