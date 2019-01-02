<div id="navigation">
    <!-- Navigation Menu-->
    <ul class="navigation-menu">
        <li class="has-submenu">
            <a href="#">
                <i class="ti-user"></i>
                <span>商戶功能</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ URL::route('admin.users.showProfile') }}">商户资料</a></li>
                @if(Sentinel::getUser()->hasAccess('users.index') || Sentinel::getUser()->hasAccess('users'))
                    <li><a href="{{ URL::to('admin/users') }}">商户管理</a></li>
                @endif
                @if(Sentinel::getUser()->hasAccess('account.index') || Sentinel::getUser()->hasAccess('account'))
                    <li><a href="{{ URL::to('admin/account') }}">行卡列表</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('account.createAccount') || Sentinel::getUser()->hasAccess('account'))
                    <li><a href="{{ URL::to('admin/account/createAccount') }}">行卡绑定</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('lendManage.index') || Sentinel::getUser()->hasAccess('lendManage'))
                    <li><a href="{{ URL::to('admin/lendManage') }}">下发管理</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('lendList.index') || Sentinel::getUser()->hasAccess('lendList'))
                    <li><a href="{{route('admin.lend.list.index')}}">下发申请</a></li>
                @endif
                @if(Sentinel::getUser()->hasAccess('whitelist'))
                    <li><a href="{{route('admin.whitelist.view')}}">白名單設定</a></li>
                @endif
            </ul>
        </li>


        <li class="has-submenu">
            <a href="#"><i class="ti-search"></i>查询功能</a>
            <ul class="submenu">
                <li><a href="{{ URL::to('admin/logQuery') }}">订单查询</a></li>

                @if(Sentinel::getUser()->hasAccess('search.reportIndex') || Sentinel::getUser()->hasAccess('search'))
                    <li><a href="{{ URL::to('admin/search/report/view') }}">报表查询</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('search.reportStatIndex') || Sentinel::getUser()->hasAccess('search'))
                    <li><a href="{{ URL::to('admin/search/reportStat/view') }}">报表统计</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess(\App\Constants\PermissionSubjectConstants::FILL_ORDER) ||
                    Sentinel::getUser()->inRole(\App\Constants\Roles\RolesConstants::ADMIN))
                    <li><a href="{{ route('admin.fill_order.view') }}">补单管理</a></li>
                @endif
            </ul>
        </li>

        <li class="has-submenu">
            <a href="#"><i class="ti-write"></i>历程记录</a>
            <ul class="submenu">
                <li><a href="{{ URL::to('admin/activity_log') }}">帐户历程</a></li>
            </ul>
        </li>

        <li class="has-submenu ml-auto"></li>

        @if (Sentinel::getUser()->hasAccess('permission'))
            <li class="has-submenu">
                <a href="#"><i class="ti-settings"></i>系统设置</a>
                <ul class="submenu">
                    <li><a href="#">群组设定</a></li>
                    <li><a href="#">权限设定</a></li>
                </ul>
            </li>
        @endif

        <li class="has-submenu">
            <a href="https://hackmd.io/s/S1hn8pDaX" target="_blank"><i class="ti-link"></i>串接文件</a>
        </li>
    </ul>
    <!-- End navigation menu -->
</div>
