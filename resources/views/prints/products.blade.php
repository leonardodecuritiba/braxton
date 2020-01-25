@extends('prints.template')
@section('body_content')
    <table border="1" class="table table-condensed table-bordered">
        <tr class="fundo_titulo">
            <th class="linha_titulo" colspan="3">Listagem de Produtos</th>
        </tr>
        @foreach($Products as $product)
            <tr>
                <td width="20%">
                    <img src="{{ $all ? $product->getThumbImage() : $product->getThumbPrintImage() }}">
                </td>
                <td width="25%">
                    <table class="table table-condensed">
                        <tr class="campo">
                            <th>CÓDIGO</th>
                        </tr>
                        <tr>
                            <td style="font-size: 35px;"><b>{{$product->code}}</b></td>
                        </tr>
                    </table>
                </td>
                <td width="55%">
                    <table border="1" class="table table-condensed table-bordered">
                        <tr class="campo">
                            <th width="15%">ID</th>
                            <th width="70%">NOME</th>
                            <th width="15%">UNIDADE</th>
                        </tr>
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->getUnitName()}}</td>
                        </tr>
                        <tr class="campo">
                            <th colspan="3">DESCRIÇÃO</th>
                        </tr>
                        <tr>
                            <td colspan="3">{{$product->description}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
@endsection