<section class="section-access">
    @if(isset($Data) )
        @role('admin')
            <div class="row clearfix">
                @include('layouts.inc.client.text')
            </div>
            <hr>
        @endrole
    @endif

    <h2 class="card-inside-title">Dados de Acesso</h2>
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'control-label'))) !!}
                    {{Form::text('name', old('name',(isset($Data) ? $Data->user->name : "")), ['id'=>'name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('email', 'Email *', array('class' => 'control-label'))) !!}
                    {{Form::email('email', old('email',(isset($Data) ? $Data->user->email : "")), ['id'=>'email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
        @if(!isset($Data))
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        {!! Html::decode(Form::label('password', 'Senha *', array('class' => 'control-label'))) !!}
                        {{Form::text('password','', ['id'=>'password','class'=>'form-control','minlength'=>'3', 'maxlength'=>'50', 'required'])}}
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>