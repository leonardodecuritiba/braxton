<section class="section-access">

    @if(isset($Data) )
    <div class="row clearfix">

        @include('layouts.inc.author.text')

        <div class="col-sm-6">
            <h5>Controladora</h5>
            <p class="m-t-15 m-b-15 col-teal">{{$Data->getDeviceName()}}</p>
        </div>
    </div>
    @else
        <h5>Controladora</h5>
        <p class="m-t-15 m-b-15 col-teal">{{$Page->auxiliar['parent']->getShortName()}}</p>
        {{Form::hidden('device_id', $Page->auxiliar['parent']->id)}}
    @endif
    <hr>

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'control-label'))) !!}
                    {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('sensor_types', 'Tipo de Sensor *', array('class' => 'control-label'))) !!}
                    {{Form::select('sensor_type_id', $Page->auxiliar['sensor_types'], old('sensor_type_id',(isset($Data) ? $Data->sensor_type_id : (isset($Page->auxiliar['sensor_type_id']) ? $Page->auxiliar['sensor_type_id'] : ''))), ['placeholder' => 'Escolha o Tipo de Sensor', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
    </div>
</section>