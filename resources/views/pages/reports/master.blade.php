@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('entity', entity('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <!-- Sweetalert Css -->
    @include('layouts.inc.sweetalert.css')

    {{--{{Html::style('bower_components/emoji-css/_site/emoji.css')}}--}}

    <style>
        .hide {
            display: none !important;
        }
        .bootstrap-tagsinput .tag {
            font-size: 14px !important;
        }
    </style>

    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}

    <!-- Bootstrap Material Datetime Picker Css -->
    {{Html::style('bower_components/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}

    <!-- Bootstrap Tagsinput Css -->
    {{Html::style('bower_components/adminbsb-materialdesign/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}

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

        @if(isset($Data))

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Relatórios Agendados - <i>{{count($Page->auxiliar['logs'])}} Registros</i>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Executado Em</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Executado Em</th>
                                        <th>Ação</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>
                                    @foreach ($Page->auxiliar['logs'] as $sel)
                                        <tr>
                                            <td>{{ $sel['id'] }}</td>
                                            <td data-order="{{$sel['created_at']}}">{{$sel['created_at']}}</td>
                                            <td>
                                                <a href="{{ route('reports_logs.show', $sel['id']) }}" target="_blank"
                                                   class="btn btn-simple btn-xs btn-default waves-effect"><i
                                                            class="material-icons">remove_red_eye</i></a>
                                                <button data-href="{{route('reports_logs.destroy', $sel['id'])}}"
                                                        class="btn btn-simple btn-xs btn-danger btn-icon"
                                                        onclick="showDeleteTableMessage(this)"
                                                        data-entity="{{'Relatório Agendado'}}"><i
                                                            class="material-icons">remove_circle_outline</i></button>
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

    <!-- Moment Plugin Js -->
    {{Html::script('bower_components/adminbsb-materialdesign/plugins/momentjs/moment.js')}}

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    {{Html::script('bower_components/adminbsb-materialdesign/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}
    <script>
        $(function () {

            $('.datepicker').bootstrapMaterialDatePicker({
//                format: 'dddd DD MMMM YYYY',
                format: 'DD/MM/YYYY',
                clearButton: true,
                weekStart: 1,
                time: false
            });
            $('.hourpicker').bootstrapMaterialDatePicker({
                format: 'HH:mm',
                clearButton: false,
                date: false
            });
        });
    </script>

    {{--ENVIOS--}}
    <!-- Bootstrap Tags Input Plugin Js -->
    {{Html::script('bower_components/adminbsb-materialdesign/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}

    <script>
        $(function () {
            $("input#copy_email").tagsinput();
        });
    </script>



    <script>
        var $_INPUT_DEVICE_ = 'select#devices';
        var $_INPUT_SENSOR_ = 'select#sensors';
    </script>
    @include('pages.commons.inc.device-sensors-ajax-js')


    <script>

        function getSensorType($this){
            $.ajax({
                url: '{{route('ajax.get.sensor-sensor_type')}}',
                data: {id : $($this).val()},
                type: 'GET',
                dataType: "json",
                beforeSend: function (xhr, textStatus) {
                    loadingCard('show',$this);
                },
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                    loadingCard('hide',$this);
                },
                success: function (json) {
                    loadingCard('hide',$this);
                    toggleSchemaSection('show', json);
                }
            });
        }
    </script>

    <script>

        var $_SECTION_SCHEMA_               = 'section#section-schema';
        var $_SECTION_REPETITION_OPTION_    = 'section#section-repetition_option';
        var $_SECTION_DAYS_OPTION_          = $_SECTION_REPETITION_OPTION_ + ' div.days';
        var $_SECTION_DAYS_OF_WEEK_OPTION_  = $_SECTION_REPETITION_OPTION_ + ' div.days_of_week';
        var $_SECTION_INTERVALS_OPTION_     = $_SECTION_REPETITION_OPTION_ + ' div.intervals';

        var $_SECTION_SEND_ = 'section#section-send';

        var $_SELECT_SENSOR_ = 'select[name=sensor_id]';
        var $_SELECT_REPETITION_ = 'select[name=repetition]';
        var $_INPUT_SENDEMAIL_ = 'input[name=send_email]';

        function toggleRepetitionOptionSection(visibility){
            if(visibility == 'hide'){
                $($_SECTION_REPETITION_OPTION_).hide();
            } else {
                $($_SECTION_REPETITION_OPTION_).show();
            }
        }

        function toggleDaysOfWeekOption(visibility){
            if(visibility == 'hide'){
                $($_SECTION_DAYS_OF_WEEK_OPTION_).hide();
            } else {
                $($_SECTION_DAYS_OF_WEEK_OPTION_).show();
            }
        }

        function toggleDaysOption(visibility){
            if(visibility == 'hide'){
                $($_SECTION_DAYS_OPTION_).hide();
            } else {
                $($_SECTION_DAYS_OPTION_).show();
            }
        }

        function toggleIntervalsOption(visibility){
            if(visibility == 'hide'){
                $($_SECTION_INTERVALS_OPTION_).hide();
            } else {
                $($_SECTION_INTERVALS_OPTION_).show();
            }
        }

        function toggleSchemaSection(visibility){
            if(visibility == 'hide'){
                $($_SECTION_SCHEMA_).hide();
                toggleRepetitionOptionSection('hide')
            } else {
                $($_SECTION_SCHEMA_).show();
            }
        }

        function toggleSendFields(visibility){
            if(visibility == 'hide'){
                $($_SECTION_SEND_).find('input[name=main_email], input[name=copy_email]').attr('disabled',true);
            } else {
                $($_SECTION_SEND_).find('input[name=main_email], input[name=copy_email]').attr('disabled',false);
            }
        }

        $(function () {
            $($_SELECT_SENSOR_).change(function(){
                if($(this).val()!=""){
                    getSensorType($(this));
                } else {
                    toggleSchemaSection('hide');
                }
            });

            $($_SELECT_REPETITION_).change(function(){
                switch(parseInt($(this).val())){
                    case 0: //Mensalmente
                        toggleRepetitionOptionSection('show')
                        toggleDaysOfWeekOption('hide')
                        toggleDaysOption('show')
                        toggleIntervalsOption('hide')
                        break;
                    case 1: //Semanalmente
                        toggleRepetitionOptionSection('show')
                        toggleDaysOfWeekOption('show')
                        toggleDaysOption('hide')
                        toggleIntervalsOption('hide')
                        break;
                    case 2: //Diariamente
                        toggleRepetitionOptionSection('show')
                        toggleDaysOfWeekOption('hide')
                        toggleDaysOption('hide')
                        toggleIntervalsOption('show')
                        break;
                    default: //Diariamente
                        toggleRepetitionOptionSection('hide')
                        toggleDaysOfWeekOption('hide')
                        toggleDaysOption('hide')
                        toggleIntervalsOption('show')
                        break;
                }
            });

            $($_INPUT_SENDEMAIL_).change(function(){
                if($($_INPUT_SENDEMAIL_ + ':checked').length > 0){
                    toggleSendFields('show');
                } else {
                    toggleSendFields('hide');
                }
            });

            toggleSchemaSection('hide');
        });
    </script>

    @if(old('sensor_id')!=NULL || isset($Data) || isset($Page->auxiliar['device_id']))
        <script>
            var _REPORT_DATA_ = {};
            _REPORT_DATA_.device_id = "{{old('device_id',(isset($Data) ? $Data->sensor->device_id : (isset($Page->auxiliar['device_id']) ? $Page->auxiliar['device_id'] : '')))}}";
            _REPORT_DATA_.sensor_id = "{{old('sensor_id',(isset($Data) ? $Data->sensor->id : (isset($Page->auxiliar['sensor_id']) ? $Page->auxiliar['sensor_id'] : '')))}}";
            _REPORT_DATA_.repetition = "{{old('repetition',(isset($Data) ? $Data->repetition : ''))}}";
            _REPORT_DATA_.send_email = "{{old('send_email',(isset($Data) ? $Data->send_email : 0))}}";
            $(function () {
                // console.log(_REPORT_DATA_);

                //MUDANDO OS SENSORES
                $($_INPUT_DEVICE_).val(_REPORT_DATA_.device_id).trigger('change');
                getAjaxSensors($_INPUT_DEVICE_, $_INPUT_SENSOR_,_REPORT_DATA_.sensor_id);

                //MUDANDO O TIPO DE REPETIÇÃO
                $($_SELECT_REPETITION_).val(_REPORT_DATA_.repetition).trigger('change');

                // //MUDANDO O ENVIO
                $($_INPUT_SENDEMAIL_).attr('checked',(_REPORT_DATA_.send_email == "1")).trigger('change');
            });
        </script>
    @endif
@endsection