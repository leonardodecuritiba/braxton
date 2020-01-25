@if(Entrust::can($sel['entity'] . '.destroy'))
    <button data-href="{{(isset($route) ? $route : route($Page->entity.'.destroy',$sel['id']))}}"
            class="btn btn-simple btn-xs btn-danger btn-icon"
            onclick="showDeleteTableMessage(this)"
            data-entity="{{(isset($field) ? $field : $Page->name).': '.$sel['name']}}"><i
                class="material-icons">remove_circle_outline</i></button>
@endif

