<!-- Layout sidenav -->
<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical {{ auth()->user()->setting->sidenavColor() }}">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
        <img style="width: 75%;" src="{{ asset('assets/logos/m-nb-w-logo.png') }}" alt="MetisNet">
        <a href="{{ route('get-index') }}" class="app-brand-text demo sidenav-text font-weight-normal ml-2">
            <!--<span style="position: relative; bottom: -5px; left: -10px; font-size: 9px;">2.0</span>-->
        </a>

        <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>

    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1">
        <li class="sidenav-header small font-weight-semibold">OVERVIEW</li>

        <!-- Dashboards -->
        <li class="sidenav-item {{ Request::is('home') ? ' active' : '' }}">
            <a href="{{ route('get-index') }}" class="sidenav-link"><i class="sidenav-icon lnr lnr-home"></i>
                <div>Home</div>
            </a>
        </li>


        @role('member')
        <li class="sidenav-header small font-weight-semibold">METISNET</li>

        <li class="sidenav-item {{ Request::is('users') ? ' active' : '' }}">
            <a href="{{ route('get-users') }}" class="sidenav-link"><i class="sidenav-icon lnr lnr-users"></i>
                <div>Accounts</div>
            </a>
        </li>

        <li class="sidenav-item ">
            <a href="#" class="sidenav-link"><i class="sidenav-icon pe-7s-graph1"></i>
                <div>Analytics</div>
            </a>
        </li>

        <li class="sidenav-item {{ Request::is(['domains', 'domains/*']) ? ' active' : '' }}">
            <a href="{{ route('get-domains') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-globe"></i>
                <div>Domains</div>
            </a>
        </li>

        <li class="sidenav-item{{ Request::is(['servers', 'servers/*']) ? ' active' : '' }}">
            <a href="{{ route('get-servers') }}" class="sidenav-link"><i class="sidenav-icon lnr lnr-screen"></i>
                <div>Servers</div>
            </a>
        </li>

        <li class="sidenav-item ">
            <a href="#" class="sidenav-link"><i class="sidenav-icon pe-7s-lock"></i>
                <div>Roles & Permissions</div>
            </a>
        </li>

        <li class="sidenav-item{{ Request::is('settings') ? ' active' : '' }}">
            <a href="{{ route('get-application-settings') }}" class="sidenav-link">
                <i class="sidenav-icon ion ion-ios-cog"></i>
                <div>Settings</div>
            </a>
        </li>
        @endrole
    </ul>
</div>
<!-- / Layout sidenav -->