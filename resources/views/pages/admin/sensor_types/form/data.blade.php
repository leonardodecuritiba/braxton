<section class="section-access">

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('code', 'Código *', array('class' => 'control-label'))) !!}
                    {{Form::text('code', old('code',(isset($Data) ? $Data->code : "")), ['id'=>'code','class'=>'form-control','minlength'=>'1', 'maxlength'=>'20', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'control-label'))) !!}
                    {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['id'=>'description','class'=>'form-control','minlength'=>'3', 'maxlength'=>'200', 'required'])}}
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('scale', 'Escala *', array('class' => 'control-label'))) !!}
                    {{Form::text('scale', old('scale',(isset($Data) ? $Data->scale : "")), ['id'=>'scale','class'=>'form-control','minlength'=>'1', 'maxlength'=>'20', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('scale_name', 'Nome da escala *', array('class' => 'control-label'))) !!}
                    {{Form::text('scale_name', old('scale_name',(isset($Data) ? $Data->scale_name : "")), ['id'=>'scale_name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'200', 'required'])}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-3">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('range[0]', 'Mínimo *', array('class' => 'control-label'))) !!}
                    {{Form::number('range[0]', old('range[0]',(isset($Data) ? $Data->getMinValue() : "")), ['id'=>'range[0]','class'=>'form-control', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('range[1]', 'Máximo *', array('class' => 'control-label'))) !!}
                    {{Form::number('range[1]', old('range[1]',(isset($Data) ? $Data->getMaxValue() : "")), ['id'=>'range[1]','class'=>'form-control', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('type', 'Tipo *', array('class' => 'control-label'))) !!}
                    {{Form::select('type', [0=>'Inteiro', 1=>'Float'], old('type',(isset($Data) ? $Data->type : (isset($Page->auxiliar['type']) ? $Page->auxiliar['type'] : ''))), ['placeholder' => 'Escolha o Tipo', 'class'=>'form-control show-tick', 'required'])}}
                </div>
            </div>
        </div>
    </div>
</section>