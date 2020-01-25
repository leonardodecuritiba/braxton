<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group form-float">
            <div class="form-line">
                {!! Html::decode(Form::label('about', 'Sobre', array('class' => 'control-label'))) !!}
                {{Form::text('about', old('about',(isset($Data) ? $Data->about : "")), ['id'=>'about','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            </div>
        </div>
    </div>
</div>