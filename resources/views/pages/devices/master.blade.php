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
        @if(isset($Data) && Entrust::can('sensors.index'))
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Sensores - <i>{{count($Data->sensors)}} Registros</i>
                                @if(Entrust::can('sensors.create'))
                                    <a href="{{route('sensors.create',$Data->id)}}"
                                       class="btn bg-indigo waves-effect pull-right">
                                        <i class="material-icons">add_circle</i>
                                        <span>{{trans('pages.view.CREATE', [ 'name' => 'Sensor' ])}}</span>
                                    </a>
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            @if(count($Data->sensors) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Autor</th>
                                            <th>Nome</th>
                                            <th>Grandeza</th>
                                            <th>Alertas</th>
                                            <th>Relatórios</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Cadastro</th>
                                            <th>Autor</th>
                                            <th>Nome</th>
                                            <th>Grandeza</th>
                                            <th>Alertas</th>
                                            <th>Relatórios</th>
                                            <th>Ação</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach ($Data->sensors as $s)
	                                        <?php
	                                        $sel = $s->getMapList();
	                                        ?>
                                            <tr class="{{$sel['active']['active_row_color']}}">
                                                <td>{{ $sel['id'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                                </td>
                                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                                <td>{{$sel['author']}}</td>
                                                <td>{{$sel['name']}}</td>
                                                <td>{{$sel['sensor_type']}}</td>
                                                <td>{{$sel['n_alerts']}}</td>
                                                <td>{{$sel['n_reports']}}</td>
                                                <td class="text-right">
                                                    @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                                    @include('layouts.inc.buttons.edit',['route'=>route('sensors.edit',$sel['id'])])
                                                    @include('layouts.inc.buttons.delete',['field' => 'Sensor', 'route'=>route('sensors.destroy',$sel['id'])])
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            @else
                                <h6>Nenhum Sensor Cadastrado</h6>
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