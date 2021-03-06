@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('entity', entity('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <!-- Sweetalert Css -->
    @include('layouts.inc.sweetalert.css')

    <style>
        .hide {
            display: none !important;
        }
    </style>

    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}
@endsection

@section('page_content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                {{$Page->main_title}}
            </h2>
        </div>

        @include('layouts.inc.breadcrumb')
        <!-- Advanced Validation -->

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Dados Principais</h2>
                    </div>
                    <div class="body">
                        @if(isset($Data))

                            @include('layouts.inc.active.alert')

                            {{Form::model($Data,
                            array(
                                'route' => array($Page->entity.'.update', $Data->id),
                                'id' => 'form_validation',
                                'method' => 'PATCH'
                            )
                            )}}
                        @else
                            {!! Form::open(['route' => $Page->entity.'.store',
                                'id' => 'form_validation',
                                'method' => 'POST']) !!}
                        @endif

                        @include($Page->main_folder.'.form.data')

                        <div class="align-right">
                            <button class="btn btn-lg btn-primary waves-effect" type="submit">Salvar</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        @if(isset($Data) && Entrust::can('alerts.index'))
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Alertas - <i>{{count($Data->alerts)}} Registros</i>
                                @if(Entrust::can('alerts.create'))
                                    <a href="{{route('alerts.create',$Data->id)}}"
                                       class="btn bg-indigo waves-effect pull-right">
                                        <i class="material-icons">add_circle</i>
                                        <span>{{trans('pages.view.CREATE', [ 'name' => 'Alerta' ])}}</span>
                                    </a>
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            @if(count($Data->alerts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Nome</th>
                                            <th>Condição</th>
                                            <th>Horário</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Nome</th>
                                            <th>Condição</th>
                                            <th>Horário</th>
                                            <th>Ação</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach ($Data->alerts as $s)
										    <?php
										    $sel = $s->getMapList();
										    ?>
                                            <tr class="{{$sel['active']['active_row_color']}}">

                                                <td>{{ $sel['id'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                                </td>
                                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                                <td>{{$sel['name']}}</td>
                                                <td>{{$sel['condition']}}</td>
                                                <td>{{$sel['time']}}</td>
                                                <td class="text-right">
                                                    @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                                    @include('layouts.inc.buttons.edit',['route'=>route('alerts.edit',$sel['id'])])
                                                    @include('layouts.inc.buttons.delete',['field' => 'Sensor', 'route'=>route('alerts.destroy',$sel['id'])])
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            @else
                                <h6>Nenhum Alerta Cadastrado</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($Data) && Entrust::can('reports.index'))
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{trans('global.reports.name')}} - <i>{{count($Data->reports)}} Registros</i>
                                @if(Entrust::can('reports.create'))
                                    <a href="{{route('reports.create',$Data->id)}}"
                                       class="btn bg-indigo waves-effect pull-right">
                                        <i class="material-icons">add_circle</i>
                                        <span>{{trans('pages.view.CREATE', [ 'name' => 'Relatório' ])}}</span>
                                    </a>
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            @if(count($Data->reports) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Nome</th>
                                            <th>Sensor</th>
                                            <th>Repetição</th>
                                            <th>Intervalo</th>
                                            <th>Próxima Execução</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Nome</th>
                                            <th>Sensor</th>
                                            <th>Repetição</th>
                                            <th>Intervalo</th>
                                            <th>Próxima Execução</th>
                                            <th>Ação</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach ($Data->reports as $s)
										    <?php
										    $sel = $s->getMapList();
										    ?>
                                            <tr class="{{$sel['active']['active_row_color']}}">
                                                <td>{{ $sel['id'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                                </td>
                                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                                <td>{{$sel['name']}}</td>
                                                <td>{{$sel['sensor']}}</td>
                                                <td>{{$sel['repetition']}}</td>
                                                <td>{{$sel['interval_time']}}</td>
                                                <td data-order="{{$sel['execution_at_time']}}">{{$sel['execution_at']}}</td>
                                                <td class="text-right">
                                                    @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                                    @include('layouts.inc.buttons.edit',['route'=>route('reports.edit',$sel['id'])])
                                                    @include('layouts.inc.buttons.delete',['field' => 'Sensor', 'route'=>route('reports.destroy',$sel['id'])])
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            @else
                                <h6>Nenhum Relatório Cadastrado</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script_content')

    @include('layouts.inc.active.js')
    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    <!-- Jquery DataTable Plugin Js -->
    @include('layouts.inc.datatable.js')

    <!-- SweetAlert Plugin Js -->
    @include('layouts.inc.sweetalert.js')

    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

@endsection