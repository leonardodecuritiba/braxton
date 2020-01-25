<section class="section-access">

    @if(isset($Data) )
        @role('admin')
            <div class="row clearfix">
                @include('layouts.inc.client.text')
            </div>
        @endrole
        <div class="row clearfix">
            <div class="col-sm-12">
                <h5 class="">Próxima Execução</h5>
                <p class="m-t-15 m-b-15 col-red">{{$Data->getExecutionAtFormatted()}}</p>
            </div>
        </div>
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


        <section id="section-repetition">
            <div class="row clearfix">

                {{--REPETIÇÃO--}}
                <div class="col-sm-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('repetition', 'Repetir a Execução *', array('class' => 'control-label'))) !!}
                            {{Form::select('repetition', $Page->auxiliar['repetitions'], old('repetition',(isset($Data) ? $Data->repetition : (isset($Page->auxiliar['repetition']) ? $Page->auxiliar['repetition'] : ''))), ['placeholder' => 'Escolha a Repetição', 'class'=>'form-control show-tick', 'required'])}}
                        </div>
                    </div>
                </div>

                {{--HORÁRIO --}}
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
                            {!! Html::decode(Form::label('time[1]', 'Horário Final (execução) *', array('class' => 'control-label'))) !!}
                            {{Form::text('time[1]', old('time[1]',(isset($Data) ? $Data->getTimeEnd() : "23:59")), ['id'=>'time[1]','class'=>'form-control hourpicker','minlength'=>'3', 'maxlength'=>'5', 'required'])}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-repetition_option">
            <div class="row clearfix">
                <div class="col-sm-6 days">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('day', 'Todos os meses, no mesmo horário, no dia *', array('class' => 'control-label'))) !!}
                            {{Form::select('day', $Page->auxiliar['days'],  ( isset($Data) ? $Data->getMonthDayOption   () : []), [ 'class'=>'form-control show-tick'])}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 days_of_week">
                    <h2 class="card-inside-title">Dias da Semana</h2>
                    <div class="form-group form-float">
                        <div class="form-line">
                            @foreach($Page->auxiliar['days_of_week'] as $key => $day)
                                <input type="radio" id="basic_radio{{$key}}" name="day_of_week" class="filled-in" value="{{$key}}"
                                        {{(
                                            (!isset($Data) && ($key == 0)) || ( isset($Data) && ($Data->dayIsChecked($key)) )
                                         )?'checked':''}}
                                >{!! Html::decode(Form::label('basic_radio' . $key, $day,['class'=>'m-l-20'])) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 intervals">
                    <div class="form-group form-float">
                        <div class="form-line">
                            {!! Html::decode(Form::label('interval', 'Resolução *', array('class' => 'control-label'))) !!}
                            {{Form::select('interval', $Page->auxiliar['intervals'], ( isset($Data) ? $Data->interval : []), [ 'class'=>'form-control show-tick'])}}
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{--FORMA DE ENVIO--}}
        <section id="section-send">

            <hr>
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