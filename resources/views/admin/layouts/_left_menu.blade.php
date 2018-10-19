<ul id="menu" class="page-sidebar-menu">

    {{--#Trade Query(index)--}}
    <li {!! (Request::is('admin/logQuery') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/logQuery') }}">
            <i class="livicon" data-name="table" data-size="18" data-c="#e9573f" data-hc="#e9573f" data-loop="true"></i>
            <span class="title">{{ trans('Trade/LogQuery/title.title') }}</span>
        </a>
    </li>

    {{--#User--}}
    <li {!! (Request::is('admin/users') || Request::is('admin/account') || Request::is('admin/account/createAccount') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="user" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">{{ trans('users/title.title') }}</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">

            <li {!! ((Request::is('admin/users/showProfile')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::route('admin.users.showProfile') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('users/title.viewProfile') }}
                </a>
            </li>

            @if(Sentinel::getUser()->hasAccess('account.index') || Sentinel::getUser()->hasAccess('account'))
                <li {!! (Request::is('admin/account') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{ URL::to('admin/account') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('users/title.accountList') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('account.createAccount') || Sentinel::getUser()->hasAccess('account'))
                <li {!! (Request::is('admin/account/createAccount') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{ URL::to('admin/account/createAccount') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('users/title.createAccount') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('users.index') || Sentinel::getUser()->hasAccess('users'))
                <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{ URL::to('admin/users') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('users/title.users') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('users.create') || Sentinel::getUser()->hasAccess('users'))
                <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{ URL::to('admin/users/create') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('users/title.addUser') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('users.getDeletedUsers') || Sentinel::getUser()->hasAccess('users'))
                <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{ URL::to('admin/deleted_users') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('users/title.deletedUsers') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>

    {{--#Lend Manage--}}
    <li {!! (Request::is('admin/showLending') || Request::is('admin/lendApply') || Request::is('admin/lendManage') ? 'class="active"' : '') !!}>

        <a href="{{ URL::to('admin/auth_code') }}">
            <i class="livicon" data-name="balance" data-c="#418bca" data-hc="#418bca" data-size="18"
               data-loop="true"></i>
            <span class="title">
                {{ trans('Trade/title.title') }}
            </span>
            <span class="fa arrow"></span>
        </a>

        <ul class="sub-menu">

            @if(Sentinel::getUser()->hasAccess('showLending.index') || Sentinel::getUser()->hasAccess('showLending'))
                <li {!! (Request::is('admin/showLending') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('admin/showLending') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('Trade/showLending/title.title') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('lendApply.index') || Sentinel::getUser()->hasAccess('lendApply'))
                <li {!! (Request::is('admin/lendApply') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('admin/lendApply') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('Trade/LendApply/title.title') }}
                    </a>
                </li>
            @endif

            @if(Sentinel::getUser()->hasAccess('lendManage.index') || Sentinel::getUser()->hasAccess('lendManage'))
                <li {!! (Request::is('admin/lendManage') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('admin/lendManage') }}">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('Trade/LendManage/title.title') }}
                    </a>
                </li>
            @endif


        </ul>
    </li>

    {{--#Activity Log--}}
    <li {!! (Request::is('admin/activity_log') ? 'class="active"' : '') !!}>
        <a href="{{  URL::to('admin/activity_log') }}">
            <i class="livicon" data-name="eye-open" data-size="18" data-c="#F89A14" data-hc="#F89A14"
               data-loop="true"></i>
            {{ trans('ActivityLog/title.title') }}
        </a>
    </li>

    @if(Sentinel::getUser()->hasAccess('permission'))
        <li>
            <a href="#">
                <i class="livicon" data-name="gear" data-c="#e9573f" data-hc="#e9573f" data-size="18"
                   data-loop="true"></i>
                <span class="title">
                    权限管理
                </span>
                <span class="fa arrow"></span>
            </a>

            <ul class="sub-menu">
                <li>
                    <a href="#">
                        <i class="fa fa-angle-double-right"></i>
                        权限群组
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.permission.switch') }}">
                        <i class="fa fa-angle-double-right"></i>
                        权限设置
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @include('admin/layouts/menu')

    {{--#Trade Query(index)--}}
    <li>
        <a href="/doc/3rdPay_API.pdf">
            <i class="livicon" data-name="doc-portrait" data-size="18" data-c="#67C5DF" data-hc="#67C5DF"
               data-loop="true"></i>
            <span class="title">{{ trans('general.document') }}</span>
        </a>
    </li>
</ul>
