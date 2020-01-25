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


    <!-- Colorpicker Css -->
    {{Html::style('bower_components/adminbsb-materialdesign/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}

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

                        @include('pages.dashboards.form.data')

                        <div class="align-right">
                            <button class="btn btn-lg btn-primary waves-effect" type="submit">Salvar</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
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

    <!-- Bootstrap Colorpicker Js -->
    {{Html::script('bower_components/adminbsb-materialdesign/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}

    <script>
        $(function () {
            $('.colorpicker').colorpicker();

        });
    </script>


    <script>
        var $_INPUT_DEVICE_ = 'select#devices';
        var $_INPUT_SENSOR_ = 'select#sensors';
    </script>
    @include('pages.commons.inc.device-sensors-ajax-js')


@endsection