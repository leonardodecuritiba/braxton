<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info" style="height: 90px !important;">
        {{--<div class="image">--}}
            {{--<img src="{{asset('bower_components/adminbsb-materialdesign/images/user.png')}}" width="48" height="48"--}}
                 {{--alt="User"/>--}}
        {{--</div>--}}
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true"
                 aria-expanded="false">{{Auth::user()->getShortName()}}</div>
            <div class="email">{{Auth::user()->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{route('users.profile')}}"><i class="material-icons">person</i>Profile</a>
                    </li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">Principal</li>
            <li @if(Route::currentRouteName()=='index') class="active" @endif>
                <a href="{{route('index')}}">
                    <i class="material-icons">home</i>
                    <span>Início</span>
                </a>
            </li>

            @if(Entrust::can('dashboards.index'))

                <li @if(Route::currentRouteName()=='dashboards.index') class="active" @endif>
                    <a href="{{route('dashboards.index')}}">
                        <i class="material-icons">timeline</i>
                        <span>{{trans('global.dashboards.name')}}</span>
                    </a>
                </li>

            @endif


            @if(Entrust::can('clients.index'))

                <li @if(Route::currentRouteName()=='clients.index') class="active" @endif>
                    <a href="{{route('clients.index')}}">
                        <i class="material-icons">people_outline</i>
                        <span>{{trans('global.clients.name')}}</span>
                    </a>
                </li>

            @endif

            @if(Entrust::can('sub_clients.index'))

                <li @if(Route::currentRouteName()=='sub_clients.index') class="active" @endif>
                    <a href="{{route('sub_clients.index')}}">
                        <i class="material-icons">people</i>
                        <span>{{trans('global.sub_clients.name')}}</span>
                    </a>
                </li>

            @endif

            @if(Entrust::can('devices.index'))

                <li @if(Route::currentRouteName()=='devices.index') class="active" @endif>
                    <a href="{{route('devices.index')}}">
                        <i class="material-icons">device_hub</i>
                        <span>{{trans('global.devices.name')}}</span>
                    </a>
                </li>

            @endif

            @if(Entrust::can('alerts.index'))

                <li @if(Route::currentRouteName()=='alerts.index') class="active" @endif>
                    <a href="{{route('alerts.index')}}">
                        <i class="material-icons">notifications_active</i>
                        <span>{{trans('global.alerts.name')}}</span>
                    </a>
                </li>

            @endif

            @if(Entrust::can('reports.index'))

                <li @if(Route::currentRouteName()=='reports.index') class="active" @endif>
                    <a href="{{route('reports.index')}}">
                        <i class="material-icons">assessment</i>
                        <span>{{trans('global.reports.name')}}</span>
                    </a>
                </li>

            @endif

            @role('admin')

                <li class="header">Administração</li>

                <li @if(Route::currentRouteName()=='admins.index') class="active" @endif>
                    <a href="{{route('admins.index')}}">
                        <i class="material-icons">android</i>
                        <span>{{trans('global.admins.name')}}</span>
                    </a>
                </li>

                <li @if(Route::currentRouteName()=='sensor_types.index') class="active" @endif>
                    <a href="{{route('sensor_types.index')}}">
                        <i class="material-icons">input</i>
                        <span>{{trans('global.sensor_types.name')}}</span>
                    </a>
                </li>

                <li @if(Route::currentRouteName()=='permissions.index') class="active" @endif>
                    <a href="{{route('permissions.index')}}">
                        <i class="material-icons">lock</i>
                        <span>{{trans('global.permissions.name')}}</span>
                    </a>
                </li>

            @endrole





            {{--@role(['manager','buyer','financial'])--}}
            {{--<li @if($menu_recursos_humanos) class="active" @endif>--}}
                {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                    {{--<i class="material-icons">people</i>--}}
                    {{--<span>Recursos Humanos</span>--}}
                {{--</a>--}}
                {{--<ul class="ml-menu">--}}
                    {{--@role(['manager','financial'])--}}
                    {{--<li @if(Route::currentRouteName()=='clients.index') class="active" @endif>--}}
                        {{--<a href="{{route('clients.index')}}">Clientes</a>--}}
                    {{--</li>--}}
                    {{--@endrole--}}
                    {{--@role(['manager','buyer','financial'])--}}
                    {{--<li @if(Route::currentRouteName()=='suppliers.index') class="active" @endif>--}}
                        {{--<a href="{{route('suppliers.index')}}">Fornecedores</a>--}}
                    {{--</li>--}}
                    {{--@endrole--}}
                    {{--@role(['manager'])--}}
                    {{--<li @if(Route::currentRouteName()=='collaborators.index') class="active" @endif>--}}
                        {{--<a href="{{route('collaborators.index')}}">Funcionários</a>--}}
                    {{--</li>--}}
                    {{--@endrole--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@endrole--}}
            {{--<li @if($menu_configs) class="active" @endif>--}}
                {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                    {{--<i class="material-icons">assignment</i>--}}
                    {{--<span>Gestão de Recursos</span>--}}
                {{--</a>--}}
                {{--<ul class="ml-menu">--}}
                    {{--@role(['manager','financial'])--}}
                    {{--<li @if(Route::currentRouteName()=='metric_units.index') class="active" @endif>--}}
                        {{--<a href="{{route('metric_units.index')}}">Unidades de Medidas</a>--}}
                    {{--</li>--}}
                    {{--<li @if(Route::currentRouteName()=='groups.index') class="active" @endif>--}}
                        {{--<a href="{{route('groups.index')}}">Grupos</a>--}}
                    {{--</li>--}}
                    {{--<li @if(Route::currentRouteName()=='sub_groups.index') class="active" @endif>--}}
                        {{--<a href="{{route('sub_groups.index')}}">Sub-Grupos</a>--}}
                    {{--</li>--}}
                    {{--<li @if(Route::currentRouteName()=='plights.index') class="active" @endif>--}}
                        {{--<a href="{{route('plights.index')}}">Empenhos</a>--}}
                    {{--</li>--}}
                    {{--<li @if(Route::currentRouteName()=='brands.index') class="active" @endif>--}}
                        {{--<a href="{{route('brands.index')}}">Marcas</a>--}}
                    {{--</li>--}}
                    {{--@endrole--}}
                    {{--<li @if(Route::currentRouteName()=='products.index') class="active" @endif>--}}
                        {{--<a href="{{route('products.index')}}">Produtos</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li @if($menu_activities) class="active" @endif>--}}
                {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                    {{--<i class="material-icons">build</i>--}}
                    {{--<span>Gestão de Atividades</span>--}}
                {{--</a>--}}
                {{--<ul class="ml-menu">--}}
                    {{--<li @if(Route::currentRouteName()=='requisitions.index') class="active" @endif>--}}
                        {{--<a href="{{route('requisitions.index')}}">Requisições</a>--}}
                    {{--</li>--}}
                    {{--@role(['coordenator','manager','financial'])--}}
                    {{--<li @if(Route::currentRouteName()=='requisitions.request') class="active" @endif>--}}
                        {{--<a href="{{route('requisitions.request')}}">Abrir Requisição</a>--}}
                    {{--</li>--}}
                    {{--@endrole--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@role(['manager','financial'])--}}
            {{--<li @if($menu_reports) class="active" @endif>--}}
                {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                    {{--<i class="material-icons">show_chart</i>--}}
                    {{--<span>Relatórios</span>--}}
                {{--</a>--}}
                {{--<ul class="ml-menu">--}}
                    {{--<li @if(Route::currentRouteName()=='requisitions.report') class="active" @endif>--}}
                        {{--<a href="{{route('requisitions.report')}}">Requisições</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                            {{--<i class="material-icons">assessment</i>--}}
                            {{--<span>Produtos</span>--}}
                        {{--</a>--}}
                        {{--<ul class="ml-menu">--}}
                            {{--<li @if(Route::currentRouteName()=='products.report') class="active" @endif>--}}
                                {{--<a href="{{route('products.report')}}">Listar</a>--}}
                            {{--</li>--}}
                            {{--<li @if(Route::currentRouteName()=='products.print-all') class="active" @endif>--}}
                                {{--<a href="{{route('products.print-all')}}" target="_blank">Imprimir Todos</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@endrole--}}
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2017 <a href="javascript:void(0);">{{ config('app.name', 'Braxton') }}</a>
        </div>
        <div class="version">
            <b>Version: </b> 1.0
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active in active" id="settings">
            <div class="demo-settings">
                <p>GENERAL SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Report Panel Usage</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Email Redirect</span>
                        <div class="switch">
                            <label><input type="checkbox"><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
                <p>SYSTEM SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Notifications</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Auto Updates</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
                <p>ACCOUNT SETTINGS</p>
                <ul class="setting-list">
                    <li>
                        <span>Offline</span>
                        <div class="switch">
                            <label><input type="checkbox"><span class="lever"></span></label>
                        </div>
                    </li>
                    <li>
                        <span>Location Permission</span>
                        <div class="switch">
                            <label><input type="checkbox" checked><span class="lever"></span></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
<!-- #END# Right Sidebar -->