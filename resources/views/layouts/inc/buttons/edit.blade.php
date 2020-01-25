@if(Entrust::can($sel['entity'] . '.edit'))
    <a href="{{(isset($route) ? $route : route($Page->entity.'.edit',$sel['id']))}}"
       class="btn btn-simple btn-warning btn-xs btn-icon edit"
       data-toggle="tooltip"
       data-placement="top"
       title="Editar"><i class="material-icons">edit</i></a>
@endif