<section class="section-pf">
    <h2 class="card-inside-title">Dados do Responsável</h2>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('cpf', 'CPF *', array('class' => 'control-label'))) !!}
                    {{Form::text('cpf', old('cpf',(isset($Data) ? $Data->getFormattedCpf() : "")), ['id'=>'cpf','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('rg', 'RG *', array('class' => 'control-label'))) !!}
                    {{Form::text('rg', old('rg',(isset($Data) ? $Data->getFormattedRg() : "")), ['id'=>'rg','class'=>'form-control show-rg','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('birthday', 'Data de Nascimento *', array('class' => 'control-label'))) !!}
                    {{Form::text('birthday', old('birthday',(isset($Data) ? $Data->getFormattedBirthday() : "")), ['id'=>'birthday','class'=>'form-control show-date', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <input name="sex" type="radio" class="with-gap" value="0" @if((isset($Data) && !$Data->sex) || old('sex')==0) checked
                   @endif id="female"/>
            <label for="female">Feminino</label>
            <input name="sex" type="radio" class="with-gap" value="1" @if((isset($Data) && $Data->sex) || old('sex')==1) checked
                   @endif id="male"/>
            <label for="male">Masculino</label>
        </div>
    </div>
</section>