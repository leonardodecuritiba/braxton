@extends('prints.template')
@section('body_content')
    @include('prints.inc.company')
    @include('prints.inc.client')
    <table border="1" class="table table-condensed table-bordered">
        <tr class="fundo_titulo_3">
            <th class="linha_titulo" colspan="5">REQUISIÇÃO</th>
        </tr>
        <tr class="campo">
            <th width="10%">ID</th>
            <th colspan="2" width="40%">UNIDADE / OBRA</th>
            <th colspan="2">AUTOR</th>
        </tr>
        <tr class="value-small">
            <td>{{ $Requisition->id }}</td>
            <td colspan="2">{{ $Requisition->getUnitShortName() . ' / ' . $Requisition->getJobShortName() }}</td>
            <td colspan="2">{{ $Requisition->getAuthorShortName() }}</td>
        </tr>
        <tr class="campo">
            <th colspan="2">EMPENHO</th>
            <th colspan="2">GRUPO / SUBGRUPO</th>
            <th class="valor">TOTAL</th>
        </tr>
        <tr class="value-small">
            <td colspan="2">{{ $Requisition->plight->getShortName() }}</td>
            <td colspan="2">{{ $Requisition->group->getShortName() . ' / ' . $Requisition->subgroup->getShortName()}}</td>
            <td class="valor">{{ $Requisition->getTotalMoney() }}</td>
        </tr>
        <tr class="campo">
            <th colspan="5">DESCRIÇÃO GERAL</th>
        </tr>
        <tr class="value-small">
            <td colspan="5">{{ $Requisition->main_descriptions}}</td>
        </tr>
        <tr class="campo">
            <th>VENCIMENTO</th>
            <th>PARCELAS</th>
            <th colspan="2">TIPO DE DOCUMENTO</th>
            <th>NÚMERO DO DOCUMENTO</th>
        </tr>
        <tr class="value-small">
            <td>{{ $Requisition->getFormattedDue() }}</td>
            <td>{{ $Requisition->getDocTypeText() }}</td>
            <td colspan="2">{{ $Requisition->getParcelasText() }}</td>
            <td>{{ $Requisition->getDocumentNumber() }}</td>
        </tr>
        <tr class="campo">
            <th colspan="2">ENDEREÇO</th>
            <th>HORA</th>
            <th>CONTATO</th>
            <th>TELEFONE</th>
        </tr>
        <tr class="value-small">
            <td colspan="2">{{ $Requisition->getAddress() }}</td>
            <td>{{ $Requisition->getHour() }}</td>
            <td>{{ $Requisition->getContact() }}</td>
            <td>{{ $Requisition->getPhone() }}</td>
        </tr>
    </table>
    @include('prints.inc.products')
@endsection