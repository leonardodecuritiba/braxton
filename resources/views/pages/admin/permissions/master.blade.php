@extends('layouts.app')

@section('title', $Page->page_title)

{{--@section('entity', entity('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <style>
        .hide {
            display: none !important;
        }
    </style>

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
                        @include($Page->main_folder.'.form.data')
                    </div>
                </div>
            </div>
        </div>

        @if(isset($Data) && Entrust::can('permissions.index'))
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Permissões - <i>{{count($Page->auxiliar['permissions'])}} Registros</i>
                            </h2>
                        </div>
                        <div class="body">
                            @if(count($Page->auxiliar['permissions']) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Situação</th>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Ação</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach ($Page->auxiliar['permissions'] as $s)
										    <?php
										    $sel = $s->getMapList($Data);
										    ?>
                                            <tr class="{{$sel['active']['active_row_color']}}">
                                                <td>{{ $sel['id'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                                </td>
                                                <td>{{$sel['code']}}</td>
                                                <td>{{$sel['name']}}</td>
                                                <td class="text-right">
                                                    @if(Entrust::can($sel['entity'] . '.active'))
                                                        <a class="btn btn-simple btn-{{$sel['active']['active_btn_color']}} btn-xs btn-icon active-permissions"
                                                           data-role_id="{{$Data->id}}"
                                                           data-id="{{$sel['id']}}">
                                                            <i class="material-icons">{{$sel['active']['active_btn_icon']}}</i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            @else
                                <h6>Nenhum Sensor Cadastrado</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script_content')

    <script>
        $(document).ready(function(){
            $('a.active-permissions').click(function(){
                var $this = $(this);
                $.ajax({
                    url: '{{route('ajax.set.active_permissions')}}',
                    data: {id : $($this).data('id'), role_id : $($this).data('role_id'), active : $($this).data('active')},
                    type: 'GET',
                    dataType: "json",
                    beforeSend: function (xhr, textStatus) {
                        loadingCard('show',$this);
                    },
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                        loadingCard('hide',$this);
                    },
                    success: function (json) {
                        loadingCard('hide',$this);
                        if(json.status){
                            var message = json.message;
                            var $tr = $($this).parents('tr');
                            $($tr).removeClass().addClass(message.active_row_color);
                            $($tr).find('span').removeClass().addClass('badge bg-' + message.active_color).html(message.active_text);

                            $($this).find('i.material-icons').html(message.active_btn_icon);
                            $($this).removeClass()
                                .addClass('btn btn-simple btn-xs btn-icon active btn-' + message.active_btn_color);
                            showNotification(message.active_update_color, message.active_update_message)

                        }
                    }
                });
            })
        })
    </script>

    <!-- Jquery DataTable Plugin Js -->
    @include('layouts.inc.datatable.js')


@endsection