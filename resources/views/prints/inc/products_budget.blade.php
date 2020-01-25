<table border="1" class="table table-condensed table-bordered">
    <tr class="fundo_titulo_3">
        <th class="linha_titulo" colspan="4">LISTAGEM DE PRODUTOS</th>
    </tr>
    <tr class="campo">
        <th width="10%">#</th>
        <th width="40%">PRODUTO</th>
        <th width="30%">MARCA</th>
        <th width="20%">QUANTIDADE</th>
    </tr>
    @foreach($Requisition->requisition_budgets as $sel)
        <tr class="value-small">
            <td>{{ $sel->id }}</td>
            <td>{{ $sel->getProductShortCodeName() }}</td>
            <td>{{ $sel->getBrandName() }}</td>
            <td>{{ $sel->quantity }}</td>
        </tr>
    @endforeach
</table>