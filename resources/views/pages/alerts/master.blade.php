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
                                Alertas Gerados - <i>{{count($Page->auxiliar['logs'])}} Registros</i>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gerado Em</th>
                                        <th>Detalhes</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Gerado Em</th>
                                        <th>Detalhes</th>
                                        <th>Ação</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>
                                    @foreach ($Page->auxiliar['logs'] as $sel)
                                        <tr>
                                            <td>{{ $sel['id'] }}</td>
                                            <td data-order="{{$sel['created_at']}}">{{$sel['created_at']}}</td>
                                            <td>{{$sel['message']}}</td>
                                            <td>
                                                <button data-href="{{route('alerts_logs.destroy', $sel['id'])}}"
                                                        class="btn btn-simple btn-xs btn-danger btn-icon"
                                                        onclick="showDeleteTableMessage(this)"
                                                        data-entity="{{'Alerta Gerado'}}"><i
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


    {{--ALERTA-VALORES--}}
    {{Html::script('bower_components/adminbsb-materialdesign/plugins/nouislider/nouislider.js')}}
    <script>
        var $_INPUT_VALUE_ = 'input[name=value]';
        var $_INPUT_VALUES_ = 'input[name=values]';

        //noUISlider
        var sliderTime = document.getElementById('time_inactive-value');

        //noUISlider
        var sliderValue = document.getElementById('single-value');

        //Range Example
        var rangeSlider = document.getElementById('range-value');
        $(function () {
            noUiSlider.create(sliderTime, {
                start: [{{(isset($Data)) ? $Data->getInactiveTime() : 30}}],
                connect: 'lower',
                step: 1,
                range: {
                    'min': [1],
                    'max': [60]
                }
            });
            getNoUISliderValue(sliderTime);

            noUiSlider.create(sliderValue, {
                start: [30],
                connect: 'lower',
                range: {
                    'min': [0],
                    'max': [100]
                }
            });
            getNoUISliderValue(sliderValue);

            noUiSlider.create(rangeSlider, {
                start: [10, 80],
                connect: true,
                range: {
                    'min': 0,
                    'max': 100
                }
            });
            getNoUISliderValue(rangeSlider);


        });

        //Get noUISlider Value and write on
        function getNoUISliderValue(slider) {
            slider.noUiSlider.on('update', function () {
                var val = slider.noUiSlider.get();
                $(slider).parent().find('span.js-nouislider-value').text(val);
                $(slider).parent().find('input').val(val);
            });
        }

        function setRangeValues(){

            sliderValue.noUiSlider.updateOptions({
                start: [_DATA_VALUES.mid],
                connect: 'lower',
                step: _DATA_VALUES.step,
                range: {
                    'min': [_DATA_VALUES.min],
                    'max': [_DATA_VALUES.max]
                }
            });

            rangeSlider.noUiSlider.updateOptions({
                start: [_DATA_VALUES.mid-_DATA_VALUES.midmid, _DATA_VALUES.mid+_DATA_VALUES.midmid],
                connect: true,
                step: _DATA_VALUES.step,
                range: {
                    'min': _DATA_VALUES.min,
                    'max': _DATA_VALUES.max
                }
            });
        }

    </script>

    <script>

        var $_SECTION_SCHEMA_ = 'section#section-schema';
        var $_SECTION_CONDITION_ = 'section#section-condition';
        var $_SECTION_MOMENT_ = 'section#section-moment';
        var $_SECTION_VALUES_ = 'section#section-values';
        var $_SECTION_SEND_ = 'section#section-send';

        var $_VALUE_FIELD_ = 'div.value';
        var $_VALUES_FIELD_ = 'div.values';
        var $_TIME_FIELD_ = 'div.time_inactive';

        var $_SELECT_SENSOR_ = 'select[name=sensor_id]';
        var $_SELECT_ALERT_TYPE_ = 'select[name=alert_type]';
        var $_SELECT_CONDITION_TYPE_ = 'select[name=condition_type]';
        var $_INPUT_SENDEMAIL_ = 'input[name=send_email]';
        var _DATA_VALUES = {};

        function toggleSchemaSection(visibility, data = null){
            if(visibility == 'hide'){
                $($_SECTION_SCHEMA_).hide();
                $($_SELECT_ALERT_TYPE_).val("").selectpicker("refresh");
                toggleValueSection('hide');
                toggleMomentSection('hide');
                toggleConditionSection('hide');
            } else {
                $($_SECTION_SCHEMA_).show();
                if(data.type = 'int'){
                    _DATA_VALUES.min = parseInt(data.min);
                    _DATA_VALUES.max = parseInt(data.max);
                    _DATA_VALUES.mid = parseInt(data.mid);
                    _DATA_VALUES.midmid = parseInt(data.midmid);
                    _DATA_VALUES.step = data.step;
                    _DATA_VALUES.decimals = parseInt(data.decimals);
                } else {
                    _DATA_VALUES.min = parseFloat(data.min);
                    _DATA_VALUES.max = parseFloat(data.max);
                    _DATA_VALUES.mid = parseFloat(data.mid);
                    _DATA_VALUES.midmid = parseFloat(data.midmid);
                    _DATA_VALUES.step = parseFloat(data.step);
                    _DATA_VALUES.decimals = parseInt(data.decimals);
                }
                setRangeValues();
            }
        }

        function toggleConditionSection(visibility){
            if(visibility == 'hide'){
                $($_SECTION_CONDITION_).hide();
            } else {
                $($_SECTION_CONDITION_).show();
            }
        }

        function toggleMomentSection(visibility){
            if(visibility == 'hide'){
                $($_SECTION_MOMENT_).hide();
            } else {
                $($_SECTION_MOMENT_).show();
            }
        }

        function toggleSendFields(visibility){
            if(visibility == 'hide'){
                $($_SECTION_SEND_).find('input[name=main_email], input[name=copy_email]').attr('disabled',true);
            } else {
                $($_SECTION_SEND_).find('input[name=main_email], input[name=copy_email]').attr('disabled',false);
            }
        }

        function toggleValueSection(visibility, inactive = 0){
            $($_SECTION_VALUES_).find($_VALUE_FIELD_).hide();
            $($_SECTION_VALUES_).find($_VALUES_FIELD_).hide();
            $($_SECTION_VALUES_).find($_TIME_FIELD_).hide();
            if(visibility == 'hide'){
                $($_SECTION_VALUES_).hide();
            } else {
                $($_SECTION_VALUES_).show();
                if(inactive){
                    $($_SECTION_VALUES_).find($_TIME_FIELD_).show();
                } else {
                    setRangeValues();
                }
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

            $($_SELECT_ALERT_TYPE_).change(function(){
                switch(parseInt($(this).val())){
                    case 0:
                    case 1:
                        toggleConditionSection('hide');
                        toggleMomentSection('hide');
                        toggleValueSection('hide');
                        break;
                    case 2:
                        toggleConditionSection('hide');
                        toggleMomentSection('show');
                        toggleValueSection('show',1);
                        break;
                    case 3:
                        toggleConditionSection('show');
                        toggleMomentSection('show');
                        toggleValueSection('show');
                        break;
                }
            });

            $($_SELECT_CONDITION_TYPE_).change(function(){
                $($_SECTION_VALUES_).find($_VALUE_FIELD_).hide();
                $($_SECTION_VALUES_).find($_VALUES_FIELD_).hide();
                $($_SECTION_VALUES_).find($_TIME_FIELD_).hide();

                if(parseInt($(this).val()) > 1){
                    $($_SECTION_VALUES_).find($_VALUE_FIELD_).show();
                } else {
                    $($_SECTION_VALUES_).find($_VALUES_FIELD_).show();
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
            var _ALERT_DATA_ = {};
            _ALERT_DATA_.device_id = "{{old('device_id',(isset($Data) ? $Data->sensor->device_id : (isset($Page->auxiliar['device_id']) ? $Page->auxiliar['device_id'] : '')))}}";
            _ALERT_DATA_.sensor_id = "{{old('sensor_id',(isset($Data) ? $Data->sensor->id : (isset($Page->auxiliar['sensor_id']) ? $Page->auxiliar['sensor_id'] : '')))}}";
            _ALERT_DATA_.alert_type = "{{old('alert_type',(isset($Data) ? $Data->alert_type : ''))}}";
            _ALERT_DATA_.condition_type = "{{old('condition_type',(isset($Data) ? $Data->condition_type : ''))}}";
            _ALERT_DATA_.send_email = "{{old('send_email',(isset($Data) ? $Data->send_email : 0))}}";
            $(function () {
                // console.log(_ALERT_DATA_);

                //MUDANDO OS SENSORES
                $($_INPUT_DEVICE_).val(_ALERT_DATA_.device_id).trigger('change');
                getAjaxSensors($_INPUT_DEVICE_, $_INPUT_SENSOR_,_ALERT_DATA_.sensor_id);
                //MUDANDO O TIPO DE ALERTA
                $($_SELECT_ALERT_TYPE_).val(_ALERT_DATA_.alert_type).trigger('change');
                //MUDANDO O CONDICAO
                $($_SELECT_CONDITION_TYPE_).val(_ALERT_DATA_.condition_type).trigger('change');
                // //MUDANDO O ENVIO
                $($_INPUT_SENDEMAIL_).attr('checked',(_ALERT_DATA_.send_email == "1")).trigger('change');
            });
        </script>
    @endif
@endsection