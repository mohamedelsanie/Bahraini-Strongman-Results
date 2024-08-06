<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/admin/vendors/images/'.__('admin/common.logo')) }}" alt="" class="dark-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow {{activeMenu('dashboard')}}">
                        <span class="micon bi bi-calendar4-week"></span><span class="mtext">{{ __('admin/common.sidebar.dashboard') }}</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle {{activeMenu('players')}}">
                        <span class="micon fa fa-user-o"></span><span class="mtext">{{ __('admin/common.sidebar.players') }}</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.players.index') }}" class="@if(!request()->routeIs('admin.players.create')){{activeMenu('players')}}@endif">{{ __('admin/common.sidebar.players_sub') }}</a></li>
                        <li><a href="{{ route('admin.players.create') }}" class="@if(request()->routeIs('admin.players.create')) active @endif">{{ __('admin/common.sidebar.add_player') }}</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle {{activeMenu('games')}}">
                        <span class="micon fa fa-user-o"></span><span class="mtext">{{ __('admin/common.sidebar.games') }}</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.games.index') }}" class="@if(!request()->routeIs('admin.games.create')){{activeMenu('games')}}@endif">{{ __('admin/common.sidebar.games_sub') }}</a></li>
                        <li><a href="{{ route('admin.games.create') }}" class="@if(request()->routeIs('admin.games.create')) active @endif">{{ __('admin/common.sidebar.add_game') }}</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle {{activeMenu('results')}}">
                        <span class="micon fa fa-user-o"></span><span class="mtext">{{ __('admin/common.sidebar.results') }}</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.results.page') }}" class="@if(!request()->routeIs('admin.results.create')){{activeMenu('results')}}@endif">{{ __('admin/common.sidebar.add_results') }}</a></li>
                        <li><a href="{{ route('admin.cat.results') }}" class="{{activeMenu('cat')}}">{{ __('admin/common.sidebar.results') }}</a></li>
                        <li><a href="{{ route('admin.final.results') }}" class="{{activeMenu('final')}}">{{ __('admin/common.sidebar.final_results') }}</a></li>
                    </ul>
                </li>




                {{--<li class="dropdown">--}}
                    {{--<a href="javascript:;" class="dropdown-toggle {{activeMenu('users')}}">--}}
                        {{--<span class="micon fa fa-user-o"></span><span class="mtext">{{ __('admin/common.sidebar.users') }}</span>--}}
                    {{--</a>--}}
                    {{--<ul class="submenu">--}}
                        {{--<li><a href="{{ route('admin.users.index') }}" class="@if(!request()->routeIs('admin.users.create')){{activeMenu('users')}}@endif">{{ __('admin/common.sidebar.users_sub') }}</a></li>--}}
                        {{--<li><a href="{{ route('admin.users.create') }}" class="@if(request()->routeIs('admin.users.create')) active @endif">{{ __('admin/common.sidebar.add_user') }}</a></li>--}}

                    {{--</ul>--}}
                {{--</li>--}}

                {{--<li class="dropdown">--}}
                    {{--<a href="javascript:;" class="dropdown-toggle {{activeMenu('admins')}}">--}}
                        {{--<span class="micon fa fa-user-secret"></span><span class="mtext">{{ __('admin/common.sidebar.admins') }}</span>--}}
                    {{--</a>--}}
                    {{--<ul class="submenu">--}}
                        {{--<li><a href="{{ route('admin.admins.index') }}" class="@if(!request()->routeIs('admin.admins.create')) {{activeMenu('admins')}} @endif">{{ __('admin/common.sidebar.admins_sub') }}</a></li>--}}
                        {{--<li><a href="{{ route('admin.admins.create') }}" class="@if(request()->routeIs('admin.admins.create')) active @endif">{{ __('admin/common.sidebar.add_admin') }}</a></li>--}}
                        {{--<li><a href="{{ route('admin.permissions.index') }}" class="{{activeMenu('permissions')}}">{{ __('admin/common.sidebar.permissions') }}</a></li>--}}
                        {{--<li><a href="{{ route('admin.roles.index') }}" class="{{activeMenu('roles')}}">{{ __('admin/common.sidebar.roles') }}</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                @if(AdminCan('setting-edit'))
                <li>
                    <a href="{{ route('admin.settings') }}" class="dropdown-toggle no-arrow {{activeMenu('settings')}}">
                        <span class="micon fa fa-gears"></span><span class="mtext">{{ __('admin/common.sidebar.settings') }}</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('admin.media.index') }}" class="dropdown-toggle no-arrow {{activeMenu('media')}}">
                        <span class="micon fa fa-file-image-o"></span><span class="mtext">{{ __('admin/common.sidebar.media') }}</span>
                    </a>
                </li>

                <li><div class="dropdown-divider"></div></li>
                <li><div class="sidebar-small-cap">{{ __('admin/common.sidebar.extra') }}</div></li>
                <li>
                    <a href="{{ route('admin.profile.edit') }}" class="dropdown-toggle no-arrow {{activeMenu('profile')}}">
                        <span class="micon fa fa-info-circle"></span><span class="mtext">{{ __('admin/common.sidebar.profile') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.logout') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-power-off"></span><span class="mtext">{{ __('admin/common.sidebar.logout') }}</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
