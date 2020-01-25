<div class="col-sm-12">
    <div class="form-group form-float">
        <div class="form-line">
            {!! Html::decode(Form::label('client_id', 'Cliente *', array('class' => 'control-label'))) !!}
            {{Form::select('client_id', $Page->auxiliar['clients'], old('client_id',(isset($Page->auxiliar['client_id']) ? $Page->auxiliar['client_id'] : '')), ['placeholder' => 'Escolha o Cliente', 'class'=>'form-control show-tick', 'required'])}}
        </div>
    </div>
</div>