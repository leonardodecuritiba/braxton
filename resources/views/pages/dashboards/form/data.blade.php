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
    @else

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
    @endif

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('period', 'Período *', array('class' => 'control-label'))) !!}
                    {{Form::select('period', $Page->auxiliar['periods'], old('period',(isset($Data) ? $Data->period : (isset($Page->auxiliar['period']) ? $Page->auxiliar['period'] : ''))), ['placeholder' => 'Escolha o Período', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <b>Cor *</b>
            <div class="input-group colorpicker">
                <div class="form-line">
                    <input name="color" type="hidden" class="form-control" value="{{old('color',(isset($Data) ? $Data->color : '#00AABB'))}}">
                </div>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('bullet', 'Contorno *', array('class' => 'control-label'))) !!}
                    {{Form::select('bullet', $Page->auxiliar['bullets'], old('bullet',(isset($Data) ? $Data->bullet : (isset($Page->auxiliar['bullet']) ? $Page->auxiliar['period'] : ''))), ['placeholder' => 'Escolha o Contorno', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('size', 'Tamanho *', array('class' => 'control-label'))) !!}
                    {{Form::select('size', $Page->auxiliar['sizes'], old('size',(isset($Data) ? $Data->size : (isset($Page->auxiliar['size']) ? $Page->auxiliar['size'] : ''))), ['placeholder' => 'Escolha o Tamanho', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('format', 'Formato *', array('class' => 'control-label'))) !!}
                    {{Form::select('format', $Page->auxiliar['formats'], old('format',(isset($Data) ? $Data->format : (isset($Page->auxiliar['format']) ? $Page->auxiliar['format'] : ''))), ['placeholder' => 'Escolha o Formato', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
    </div>
</section>