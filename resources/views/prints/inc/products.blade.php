<table border="1" class="table table-condensed table-bordered">
    <tr class="fundo_titulo_3">
        <th class="linha_titulo" colspan="7">LISTAGEM DE PRODUTOS</th>
    </tr>
    <tr class="campo">
        <th width="5%">#</th>
        <th width="40%">PRODUTO</th>
        <th width="20%">FORNECEDOR</th>
        <th width="13%">MARCA</th>
        <th width="5%">QTD.</th>
        <th width="10%">VALOR</th>
        <th width="10%">TOTAL</th>
    </tr>
    @foreach($Requisition->requisitionBudgetsFormatted() as $sel)
        <tr class="value-small">
            <td>{{ $sel->id }}</td>
            <td>{{ $sel->getProductShortCodeName() }}</td>
            <td>{{ $sel->buy_supplier }}</td>
            <td>{{ $sel->getBrandName() }}</td>
            <td>{{ $sel->quantity }}</td>
            <td>{{ $sel->buy_value_money }}</td>
            <td>{{ $sel->buy_total_money }}</td>
        </tr>
    @endforeach
    <tr class="linha_total">
        <td colspan="6">TOTAL</td>
        <td>{{ $Requisition->getTotalMoney() }}</td>
    </tr>
</table>