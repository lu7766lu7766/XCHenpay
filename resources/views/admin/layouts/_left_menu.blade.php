<ul id="menu" class="page-sidebar-menu">

    <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
        <a href="{{ route('admin.dashboard') }}">
            <i class="livicon" data-name="home" data-size="18" data-c="#e9573f" data-hc="#e9573f"
               data-loop="true"></i>
            <span class="title">{{ trans('general.dashboard') }}</span>
        </a>
    </li>


    <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="user" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">{{ trans('users/title.title') }}</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('users/title.users') }}
                </a>
            </li>
            <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('users/title.addUser') }}
                </a>
            </li>
            <li {!! ((Request::is('admin/users/*')) && !(Request::is('admin/users/create')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::route('admin.users.show',Sentinel::getUser()->id) }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('users/title.viewProfile') }}
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('users/title.deletedUsers') }}
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/companies') || Request::is('admin/companies/create') || Request::is('admin/companies_profile') || Request::is('admin/companies/*') || Request::is('admin/deleted_companies') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#67C5DF" data-hc="#67C5DF"
               data-loop="true"></i>
            <span class="title">{{ trans('companies/title.title') }}</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/companies') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/companies') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('companies/title.companies') }}
                </a>
            </li>
            <li {!! (Request::is('admin/companies/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/companies/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('companies/title.addCompany') }}
                </a>
            </li>
            <li {!! ((Request::is('admin/companies/*')) && !(Request::is('admin/companies/create')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::route('admin.companies.show',Sentinel::getUser()->id) }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('companies/title.viewProfile') }}
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_companies') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_companies') }}">
                    <i class="fa fa-angle-double-right"></i>
                    {{ trans('companies/title.deletedCompanies') }}
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/auth_code') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/auth_code') }}">
            <i class="livicon" data-name="table" data-c="#418bca" data-hc="#418bca" data-size="18"
               data-loop="true"></i>
            {{--<span class="title">--}}
                {{ trans('LogQuery/title.title') }}
            {{--</span>--}}
            {{--<span class="fa arrow"></span>--}}
        </a>

        {{--<ul class="sub-menu">--}}
            {{--<li {!! (Request::is('admin/auth_code') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ URL::to('admin/auth_code') }}">--}}
                    {{--<i class="fa fa-angle-double-right"></i>--}}
                    {{--{{ trans('LogQuery/title.title') }}--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    </li>

    {{--<li {!! (Request::is('admin/tasks') ? 'class="active"' : '') !!}>--}}
        {{--<a href="{{ URL::to('admin/tasks') }}">--}}
            {{--<i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="list-ul" data-size="18"--}}
               {{--data-loop="true"></i>--}}
            {{--Tasks--}}
            {{--<span class="badge badge-danger" id="taskcount">{{ Request::get('tasks_count') }}</span>--}}
        {{--</a>--}}
    {{--</li>--}}

    <li {!! (Request::is('admin/activity_log') ? 'class="active"' : '') !!}>
        <a href="{{  URL::to('admin/activity_log') }}">
            <i class="livicon" data-name="eye-open" data-size="18" data-c="#F89A14" data-hc="#F89A14"
               data-loop="true"></i>
            {{ trans('ActivityLog/title.title') }}
        </a>
    </li>
    @include('admin/layouts/menu')
</ul>