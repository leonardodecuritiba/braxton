<section class="section-access">
    <h2 class="card-inside-title">Dados de Acesso</h2>
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('username', 'Nome *', array('class' => 'control-label'))) !!}
                    {{Form::text('username', old('username',(isset($Data) ? $Data->user->name : "")), ['id'=>'username','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="@if(!isset($Data)) col-sm-6 @else col-sm-12 @endif">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('email', 'Email *', array('class' => 'control-label'))) !!}
                    {{Form::text('email', old('email',(isset($Data) ? $Data->user->email : "")), ['id'=>'email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
        @if(!isset($Data))
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Html::decode(Form::label('password', 'Senha *', array('class' => 'control-label'))) !!}
                        {{Form::password('password', ['id'=>'password','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                    </div>
                </div>
            </div>
        @endif
    </div>

</section>