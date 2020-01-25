<?php $DataAddress = (isset($Data) ? $Data->address : NULL); ?>
<h2 class="card-inside-title">Dados de Endereço</h2>
<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('street', 'Endereço', array('class' => 'control-label'))) !!}
                {{Form::text('street', old('street', (($DataAddress != null) ? $DataAddress->street : '')), ['class'=>'form-control', 'required'])}}
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('number', 'Número', array('class' => 'control-label'))) !!}
                {{Form::text('number', old('number', (($DataAddress != null) ? $DataAddress->number : '')), ['class'=>'form-control', 'required'])}}
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('complement', 'Complemento', array('class' => 'control-label'))) !!}
                {{Form::text('complement', old('complement', (($DataAddress != null) ? $DataAddress->complement : '')), ['class'=>'form-control'])}}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('district', 'Bairro', array('class' => 'control-label'))) !!}
                {{Form::text('district', old('district', (($DataAddress != null) ? $DataAddress->district : '')), ['class'=>'form-control', 'required'])}}
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-sm-3">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('zip', 'CEP', array('class' => 'control-label'))) !!}
                {{Form::text('zip', old('zip', (($DataAddress != null) ? $DataAddress->getFormatedZip() : '')), ['class'=>'form-control show-cep', 'multiple', 'required'])}}
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('state', 'Estado', array('class' => 'control-label'))) !!}
                {{Form::select('state_id', $Page->auxiliar['states'], old('state_id',(isset($DataAddress) ? $DataAddress->state_id : '')), ['placeholder' => 'Escolha o Estado', 'class'=>'form-control select2_single','id' => 'select-state', 'required'])}}
                {{--{{Form::text('state', old('state', (($DataAddress != null) ? $DataAddress->state : '')), ['class'=>'form-control'])}}--}}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('city', 'Cidade', array('class' => 'control-label'))) !!}
                {{Form::select('city_id',  ((($DataAddress != NULL) && ($DataAddress->city_id != NULL)) ? [$DataAddress->city_id => $DataAddress->city->name] : []),(($DataAddress != NULL) ? $DataAddress->city_id : ''), ['placeholder' => 'Escolha a Cidade', 'class'=>'form-control select2_single','id' => 'select-city', 'required'])}}
                {{--{{Form::text('city', old('city', (($DataAddress != null) ? $DataAddress->city : '')), ['class'=>'form-control'])}}--}}
            </div>
        </div>
    </div>
</div>