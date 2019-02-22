<div id="navigation">
    <!-- Navigation Menu-->
    <ul class="navigation-menu">
        <li class="has-submenu">
            <a href="#">
                <i class="ti-user"></i>
                <span>商戶功能</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ URL::route('admin.user.view') }}">商户资料</a></li>
                @if(Sentinel::getUser()->hasAccess('merchants') || Sentinel::getUser()->hasAccess('merchants.view'))
                    <li><a href="{{ route('admin.merchants.view') }}">商户管理</a></li>
                @endif
                @if(Sentinel::getUser()->can('management','BankCardListPolicy'))
                    <li><a href="{{ route('admin.bankCard.view') }}">行卡列表</a></li>
                @endif
                @if(Sentinel::getUser()->can('management','BindBankCardPolicy'))
                    <li><a href="{{ route('user.bankCard.bind.view') }}">行卡绑定</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('lendManage.index') || Sentinel::getUser()->hasAccess('lendManage'))
                    <li><a href="{{ URL::to('admin/lendManage') }}">下发管理</a></li>
                @endif

                @if(Sentinel::getUser()->hasAccess('lendList.index') || Sentinel::getUser()->hasAccess('lendList'))
                    <li><a href="{{route('admin.lend.list.index')}}">下发申请</a></li>
                @endif
                @if(Sentinel::getUser()->hasAccess('whitelist'))
                    <li><a href="{{route('admin.whitelist.view')}}">白名单设定</a></li>
                @endif
            </ul>
        </li>
        @if(Sentinel::getUser()->hasAccess('channel.feeList')||Sentinel::getUser()->hasAccess('channel.feeManagement'))
            <li class="has-submenu">
                <a href="#"><i class="ti-direction-alt"></i>通道设置</a>
                @if(Sentinel::getUser()->hasAccess('channel.feeManagement'))
                    <ul class="submenu">
                        <li><a href="{{route('admin.channel.feeManagement.view')}}">通道管理</a></li>
                    </ul>
                @endif
                @if(Sentinel::getUser()->hasAccess('channel.feeList'))
                    <ul class="submenu">
                        <li><a href="{{route('admin.channel.feeList.view')}}">通道列表</a></li>
                    </ul>
                @endif
            </li>
        @endif
        @if(Sentinel::getUser()->can('management','InformationManagePolicy') ||
            Sentinel::getUser()->can('management','InformationListsPolicy'))
            <li class="has-submenu">
                <a href="#"><i class="ti-email"></i>信息通知</a>
                <ul class="submenu">
                    @if(Sentinel::getUser()->can('management','InformationManagePolicy'))
                        <li><a href="{{route('admin.information.publish.view')}}">信息管理</a></li>
                    @endif
                    @if(Sentinel::getUser()->can('management','InformationListsPolicy'))
                        <li><a href="{{route('user.information.list.view')}}">信息列表</a></li>
                    @endif
                </ul>
            </li>
        @endif
        @if(Sentinel::getUser()->can('management','CompanyAccountPolicy') ||
            Sentinel::getUser()->can('management','PersonalAccountPolicy') ||
            Sentinel::getUser()->can('management', 'BankCardAccountManagePolicy'))
            <li class="has-submenu">
                <a href="#"><i class="ti-money"></i>收款管理</a>
                <ul class="submenu">
                    @if(Sentinel::getUser()->can('management', 'BankCardAccountManagePolicy'))
                        <li><a href="{{route('admin.cashier.manage.view')}}">帐户管理</a></li>
                    @endif
                    @if(Sentinel::getUser()->can('management','CompanyAccountPolicy'))
                        <li><a href="{{route('admin.cashier.company.view')}}">公司帐户</a></li>
                    @endif
                    @if(Sentinel::getUser()->can('management','PersonalAccountPolicy'))
                        <li><a href="{{route('user.cashier.personal.view')}}">帐户设置</a></li>
                    @endif
                </ul>
            </li>
        @endif
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
                @if(Sentinel::getUser()->hasAccess('notify.order.fail'))
                    <li><a href="{{ route('admin.order.fail.view') }}">回调错误记录</a></li>
                @endif
            </ul>
        </li>

        <li class="has-submenu ml-auto"></li>

        @if (Sentinel::getUser()->hasAccess('systemSetting') ||
            Sentinel::getUser()->can('management','PaymentManagePolicy'))
            <li class="has-submenu">
                <a href="#"><i class="ti-settings"></i>系统设置</a>
                <ul class="submenu">
                    <li><a href="{{ route('admin.systemSetting.accountManage') }}">帐号管理</a></li>
                    @if(Sentinel::getUser()->can('management','PaymentManagePolicy'))
                        <li><a href="{{ route('admin.systemSetting.paymentManage.view')  }}">金流管理</a></li>
                    @endif
                    {{--<li><a href="#">群组设定</a></li>--}}
                    {{--<li><a href="#">权限设定</a></li>--}}
                </ul>
            </li>
        @endif

        <li class="has-submenu">
            <a href="https://hackmd.io/s/S1hn8pDaX" target="_blank"><i class="ti-link"></i>串接文件</a>
        </li>
    </ul>
    <!-- End navigation menu -->
</div>
