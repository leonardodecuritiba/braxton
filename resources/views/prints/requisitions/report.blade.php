@extends('prints.template')
@section('body_content')
    @include('prints.inc.company')
    <table border="1" class="table table-condensed table-bordered">
        <tr class="fundo_titulo">
            <th class="linha_titulo" colspan="7">Listagem de Requisições</th>
        </tr>
        <tr class="campo">
            <th width="10%">GRUPO</th>
            <th width="10%">SUBGRUPO</th>
            <th width="10%">EMPENHO</th>
            <th width="40%">DESCRIÇÃO</th>
            <th width="10%">DATA COMPRA</th>
            <th width="10%">NR. DOCUMENTO</th>
            <th width="10%">VALOR</th>
        </tr>
        @foreach($Requisitions as $requisition)
            <tr class="value-small">
                <td>{{ $requisition->group_name }}</td>
                <td>{{ $requisition->subgroup_name }}</td>
                <td>{{ $requisition->plight_name }}</td>
                <td>{{ $requisition->main_descriptions }}</td>
                <td>{{ $requisition->buy_at_formatted }}</td>
                <td>{{ $requisition->document_number }}</td>
                <td>{{ $requisition->total_formatted }}</td>
            </tr>
        @endforeach
        <tr class="linha_total">
            <th colspan="6">TOTAL</th>
            <td class="">{{$Total}}</td>
        </tr>
    </table>
@endsection