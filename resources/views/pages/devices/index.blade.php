@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('route', route('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <!-- Sweetalert Css -->
    @include('layouts.inc.sweetalert.css')

@endsection

@section('page_content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                {{$Page->main_title}}
            </h2>
        </div>

        @include('layouts.inc.breadcrumb')

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Listagem - <i>{{count($Page->response)}} Registros</i>
                            @if(Entrust::can($Page->entity . '.create'))
                                <a href="{{route($Page->entity.'.create')}}"
                                   class="btn bg-indigo waves-effect pull-right">
                                    <i class="material-icons">add_circle</i>
                                    <span>{{trans('pages.view.CREATE', [ 'name' => $Page->name ])}}</span>
                                </a>
                            @endif
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Situação</th>
                                    <th>Cadastro</th>
                                    @role('admin')
                                    <th>Cliente</th>
                                    @endrole
                                    <th>Autor</th>
                                    <th>Nome</th>
                                    <th>Conteúdo</th>
                                    <th>Sensores</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Situação</th>
                                    <th>Cadastro</th>
                                    @role('admin')
                                    <th>Cliente</th>
                                    @endrole
                                    <th>Autor</th>
                                    <th>Nome</th>
                                    <th>Conteúdo</th>
                                    <th>Sensores</th>
                                    <th>Ação</th>
                                </tr>
                                </tfoot>

                                <tbody>
                                @foreach ($Page->response as $sel)
                                    <tr class="{{$sel['active']['active_row_color']}}">
                                        <td>{{ $sel['id'] }}</td>
                                        <td>
                                            <span class="badge bg-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                        </td>
                                        <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                        @role('admin')
                                            <td>{{$sel['client']}}</td>
                                        @endrole
                                        <td>{{$sel['author']}}</td>
                                        <td>{{$sel['name']}}</td>
                                        <td>{{$sel['short_content']}}</td>
                                        <td>{{$sel['n_sensors']}}</td>
                                        <td class="text-right">
                                            @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                            @include('layouts.inc.buttons.edit')
                                            @include('layouts.inc.buttons.delete')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
@endsection


@section('script_content')

    <script>
        $_DATATABLE_OPTIONS_.order = [2, "asc"];
    </script>
    @include('layouts.inc.active.js')

    <!-- Jquery DataTable Plugin Js -->
    @include('layouts.inc.datatable.js')

    <!-- SweetAlert Plugin Js -->
    @include('layouts.inc.sweetalert.js')

@endsection