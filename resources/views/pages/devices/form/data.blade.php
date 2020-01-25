<section class="section-access">
    @if(isset($Data) )
        @role('admin')
            <div class="row clearfix">
                @include('layouts.inc.client.text')
            </div>
        @endrole
        <div class="row clearfix">
            @include('layouts.inc.author.text')
        </div>
        <hr>
    @else
        @role('admin')
            <div class="row clearfix">
                @include('layouts.inc.client.select')
            </div>
        @endrole
    @endif

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'control-label'))) !!}
                    {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group form-float">
                <div class="form-line">
                    {!! Html::decode(Form::label('content', 'Conteúdo *', array('class' => 'control-label'))) !!}
                    {{Form::text('content', old('content',(isset($Data) ? $Data->content : "")), ['id'=>'name','class'=>'form-control','minlength'=>'3', 'maxlength'=>'200', 'required'])}}
                </div>
            </div>
        </div>
    </div>
</section>