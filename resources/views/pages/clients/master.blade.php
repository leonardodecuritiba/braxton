@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('entity', entity('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <!-- Sweetalert Css -->
    @include('layouts.inc.sweetalert.css')

    <style>
        .hide {
            display: none !important;
        }
    </style>

    @include('layouts.inc.select2.css')
@endsection

@section('page_content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                {{$Page->main_title}}
            </h2>
        </div>
    @include('layouts.inc.breadcrumb')
    <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Dados Principais</h2>
                    </div>
                    <div class="body">
                        @if(isset($Data))
                            {{Form::model($Data,
                            array(
                                'route' => array($Page->entity.'.update', $Data->id),
                                'files' => true,
                                'id' => 'form_validation',
                                'method' => 'PATCH'
                            )
                            )}}
                        @else
                            {!! Form::open(['route' => $Page->entity.'.store',
                                'files' => true,
                                'id' => 'form_validation',
                                'method' => 'POST']) !!}
                        @endif

                        @include('pages.commons.form.access')

                        <h2 class="card-inside-title">Tipo de Cliente</h2>

                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <input name="type" type="radio" class="with-gap" value="1" @if(!isset($Data)) checked
                                       @endif id="pj"/>
                                <label for="pj">Pessoa Jurídica</label>
                                <input name="type" type="radio" class="with-gap" value="0" id="pf"/>
                                <label for="pf">Pessoa Física</label>
                            </div>
                        </div>

                        @include('pages.clients.form.pj')
                        @include('pages.clients.form.pf')
                        @include('pages.commons.form.address')
                        @include('pages.commons.form.contact')

                        <div class="align-right">
                            <button class="btn btn-lg btn-primary waves-effect" type="submit">Salvar</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_content')
    <script>
        function toggleType(val){
            if(val == "1"){
                $('input[name="type"]#pj').prop('checked',true);
                $('section.section-pf').hide();
                $('section.section-pj').fadeIn('fast');
                // $('section.section-pj').find('input').not("input#ie, input#isention_ie, input#foundation").attr('required',true);
                $('section.section-pf').find('input').attr('required',false);
//                $('section.section-pf').find('input').val("");
            } else {
                $('input[name="type"]#pf').prop('checked',true);
                $('section.section-pj').hide();
                $('section.section-pf').fadeIn('fast');
                $('section.section-pf').find('input').attr('required',true);
                $('section.section-pj').find('input').attr('required',false);
//                $('section.section-pj').find('input').val("");
            }
        }
        $(document).ready(function(){
            $('input[name="type"]').change(function() {
                toggleType($(this).val());
            });
            var type = '{{(isset($Data)) ? $Data->type : 1}}';
            toggleType(type);
        })
    </script>
    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    <!-- Jquery DataTable Plugin Js -->
    @include('layouts.inc.datatable.js')

    <!-- SweetAlert Plugin Js -->
    @include('layouts.inc.sweetalert.js')

    <!-- Select2 -->
    @include('layouts.inc.select2.js')

    <script type="text/javascript">
        $(document).ready(function () {
            $(".select2_single").select2({
                width: 'resolve'
            });
        });
    </script>

    @include('layouts.inc.address.js')
@endsection