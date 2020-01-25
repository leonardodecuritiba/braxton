@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('entity', entity('cliente'))--}}

@section('style_content')


    <style>
        .hide {
            display: none !important;
        }
    </style>

@endsection


@section('page_modals')
    @include('layouts.inc.modal.change-password')

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
                        <h2>Dados Principais
                            @if(Auth::user()->itsMe( $Data->id ))
                                <a
                                    data-toggle="modal"
                                    data-target="#changePassword"
                                    class="btn btn-success waves-effect pull-right">
                                    <i class="material-icons">lock</i>
                                    <span>Alterar Senha</span>
                                </a>
                            @endif
                        </h2>
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
                        @include('pages.admin.admins.form.data')

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

    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

@endsection