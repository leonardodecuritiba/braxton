<section class="section-access">

    @if(isset($Data) )
        @role('admin')
        <div class="row clearfix">
            @include('layouts.inc.client.text')
        </div>
        @endrole
        <div class="row clearfix">

            @include('layouts.inc.author.text')
            <div class="col-sm-3">
                <h5>Controladora</h5>
                <p class="m-t-15 m-b-15 col-teal">{{$Page->auxiliar['parent']->device->getShortName()}}</p>
            </div>
            <div class="col-sm-3">
                <h5>Sensor</h5>
                <p class="m-t-15 m-b-15 col-teal">{{$Page->auxiliar['parent']->getShortName()}}</p>
            </div>
        </div>
        <hr>
    @endif

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'control-label'))) !!}
                    {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
    </div>


    <div class="row clearfix @if(isset($Data) ) hidden @endif">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('device_id', 'Controladora *', array('class' => 'control-label'))) !!}
                    {{Form::select('device_id', $Page->auxiliar['devices'], "", ['id'=>'devices','placeholder' => 'Escolha a Controladora', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('sensor_id', 'Sensor *', array('class' => 'control-label'))) !!}
                    {{Form::select('sensor_id', [], old('sensor_id',(isset($Data) ? $Data->sensor_id : (isset($Page->auxiliar['sensor_id']) ? $Page->auxiliar['sensor_id'] : ''))), ['id'=>'sensors','placeholder' => 'Escolha o Sensor', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
    </div>

    <hr>

    <section id="section-schema">
        {{--TIPO DO ALERTA--}}
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Html::decode(Form::label('alert_type', 'Tipo do Alerta *', array('class' => 'control-label'))) !!}
                        {{Form::select('alert_type', $Page->auxiliar['alert_types'], '', ['placeholder' => 'Escolha o Tipo de Alerta', 'class'=>'form-control show-tick', 'required'])}}
                    </div>
                </div>
            </div>
        </div>

        {{--CONDIÇÃO DO ALERTA--}}
        <section id="section-condition">
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('condition_type', 'Condição do Alerta *', array('class' => 'control-label'))) !!}
                            {{Form::select('condition_type', $Page->auxiliar['alert_conditions'], '', ['placeholder' => 'Escolha a Condição', 'class'=>'form-control show-tick', 'required'])}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{--VALORES--}}
        <section id="section-values">
            <div class="row clearfix">
                <div class="col-sm-12 value">
                    <p><b>Valor</b></p>
                    <div id="single-value"></div>
                    <div class="m-t-20 font-12"><b>Valor: </b><span class="js-nouislider-value"></span></div>
                    {{Form::hidden('value', '')}}
                </div>
                <div class="col-sm-12 values">
                    <p><b>Faixa</b></p>
                    <div id="range-value"></div>
                    <div class="m-t-20 font-12"><b>Valores: </b><span class="js-nouislider-value"></span></div>
                    {{Form::hidden('values', '')}}
                </div>
                <div class="col-sm-12 time_inactive">
                    <p><b>Valor</b></p>
                    <div id="time_inactive-value"></div>
                    <div class="m-t-20 font-12"><b>Tempo de inatividade (m): </b><span class="js-nouislider-value"></span></div>
                    {{Form::hidden('time_inactive', '')}}
                </div>
            </div>
            <hr>
        </section>

        {{--MOMENTO DE ENVIO--}}
        <section id="section-moment">
            <div class="row clearfix">
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('time[0]', 'Horário Inicial *', array('class' => 'control-label'))) !!}
                            {{Form::text('time[0]', old('time[0]',(isset($Data) ? $Data->getTimeBegin() : "00:00")), ['id'=>'time[0]','class'=>'form-control hourpicker','minlength'=>'3', 'maxlength'=>'5', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('time[1]', 'Horário Final *', array('class' => 'control-label'))) !!}
                            {{Form::text('time[1]', old('time[1]',(isset($Data) ? $Data->getTimeEnd() : "23:59")), ['id'=>'time[1]','class'=>'form-control hourpicker','minlength'=>'3', 'maxlength'=>'5', 'required'])}}
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <h2 class="card-inside-title">Dias da Semana</h2>
                    <div class="form-group form-float">
                        <div class="form-line">

                            @foreach($Page->auxiliar['days_of_week'] as $key => $day)
                                <input type="checkbox" id="basic_checkbox_{{$key}}" name="days[{{$key}}]" class="filled-in" value="{{$key}}"
                                        {{(
                                            (!isset($Data)) ||
                                            (
                                                 isset($Data) &&
                                                 ($Data->dayIsChecked($key))
                                             )
                                         )?'checked':''}}
                                >{!! Html::decode(Form::label('basic_checkbox_' . $key, $day,['class'=>'m-l-20'])) !!}

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <hr>
        </section>

        {{--FORMA DE ENVIO--}}
        <section id="section-send">

            <div class="row clearfix">

                <div class="col-sm-2">
                    <h2 class="card-inside-title">Envio</h2>
                    <div class="demo-switch">
                        <div class="switch">
                            <label>Inativo{{Form::checkbox('send_email','1','checked')}}<span class="lever"></span>Ativo</label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('main_email', 'Email Principal', array('class' => 'control-label'))) !!}
                            {{Form::email('main_email', old('main_email',(isset($Data) ? $Data->main_email : Auth::user()->email)), ['id'=>'main_email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100','placeholder' => 'Email principal'])}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h2 class="card-inside-title">Emails Adicionais</h2>
                    <div class="form-group form-float">
                        <div class="form-line">
                            {{Form::text('copy_email', old('copy_email',(isset($Data) ? $Data->getCopyEmailText() : "")), ['id'=>'copy_email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'500'])}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</section>