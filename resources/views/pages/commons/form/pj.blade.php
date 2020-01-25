<section class="section-pj">
    <h2 class="card-inside-title">Dados da Empresa</h2>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('rg', 'Razão Social *', array('class' => 'control-label'))) !!}
                    {{Form::text('company_name', old('company_name',(isset($Data) ? $Data->company_name : "")), ['id'=>'company_name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('fantasy_name', 'Nome Fantasia *', array('class' => 'control-label'))) !!}
                    {{Form::text('fantasy_name', old('fantasy_name',(isset($Data) ? $Data->fantasy_name : "")), ['id'=>'fantasy_name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('cnpj', 'CNPJ *', array('class' => 'control-label'))) !!}
                    {{Form::text('cnpj', old('cnpj',(isset($Data) ? $Data->cnpj : "")), ['id'=>'cnpj','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('ie', 'Insc. Estadual *', array('class' => 'control-label'))) !!}
                    {{Form::text('ie', old('ie',(isset($Data) ? $Data->ie : "")), ['id'=>'ie','class'=>'form-control show-ie','minlength'=>'3', 'maxlength'=>'20'])}}
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="checkbox" name="isention_ie" id="isention_ie"
                   {{((isset($Data) && ($Data->isention_ie)) ? "checked" : "")}} class="filled-in">
            <label for="isention_ie">Isenção I.E.</label>
        </div>
        <div class="col-sm-2">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('foundation', 'Data Fundação *', array('class' => 'control-label'))) !!}
                    {{Form::text('foundation', old('foundation',(isset($Data) ? $Data->getFormattedFoudation() : "")), ['id'=>'foundation','class'=>'form-control show-date'])}}
                </div>
            </div>
        </div>
    </div>
</section>