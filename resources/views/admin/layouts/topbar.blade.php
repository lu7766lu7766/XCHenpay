<div class="menu-extras topbar-custom">
    <ul class="float-right list-unstyled mb-0 ">
        <span id="headerInfo">
            <header-info/>
        </span>
        {{--@if(Sentinel::getUser()->hasAccess('lendManage.index') || Sentinel::getUser()->hasAccess('lendManage'))--}}
        {{--<span id="lendNotify">--}}
        {{--<lend-notify link="{{ URL::to('admin/lendManage') }}"/>--}}
        {{--</span>--}}
        {{--@endif--}}

        <li class="dropdown notification-list">
            <div class="dropdown notification-list nav-pro-img">
                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#"
                   role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.user.view') }}"><i
                                class="mdi mdi-account-circle m-r-5"></i> 商户资料</a>
                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> 锁定</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ URL::to('admin/logout') }}"><i
                                class="mdi mdi-power text-danger"></i> 登出</a>
                </div>
            </div>
        </li>
        <li class="menu-item">
            <!-- Mobile menu toggle-->
            <a class="navbar-toggle nav-link" id="mobileToggle">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <!-- End mobile menu toggle-->
        </li>
    </ul>
</div>
