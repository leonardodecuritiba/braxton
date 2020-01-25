<?php $DataContact = (isset($Data) ? $Data->contact : NULL); ?>
<h2 class="card-inside-title">Dados de Contato</h2>
<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="form-line">
                {!! Html::decode(Form::label('phone', 'Telefone', array('class' => 'control-label'))) !!}
                {{Form::text('phone', old('phone',(($DataContact != null) ? $DataContact->getFormatedPhone() : '')), ['id' => 'phone', 'class'=>'form-control show-phone'])}}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="form-line">
                {!! Html::decode(Form::label('cellphone', 'Celular', array('class' => 'control-label'))) !!}
                {{Form::text('cellphone', old('cellphone',(($DataContact != null) ? $DataContact->getFormatedCellphone() : '')), ['id' => 'cellphone', 'class'=>'form-control show-cellphone'])}}
            </div>
        </div>
    </div>
</div>