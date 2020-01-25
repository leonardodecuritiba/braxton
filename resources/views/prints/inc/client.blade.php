<table border="1" class="table table-condensed table-bordered">
    <tr class="fundo_titulo">
        <th class="linha_titulo" colspan="3">CLIENTE</th>
    </tr>
    <tr class="campo">
        <th width="10%">ID</th>
        <th width="30%">CLIENTE</th>
        <th>ENDEREÇO</th>
    </tr>
    <tr class="value-small">
        <td>{{ $Requisition->getClientId() }}</td>
        <td>{{ $Requisition->getClientShortName() }}</td>
        <td>{{ $Requisition->getUnitFullAddress() }}</td>
    </tr>
    <tr class="campo">
        <th colspan="2">CNPJ</th>
        <th>INSCRIÇÃO ESTADUAL</th>
    </tr>
    <tr class="value-small">
        <td colspan="2">{{ $Requisition->getClientShortDocument() }}</td>
        <td>{{ $Requisition->getClientIe() }}</td>
    </tr>
</table>