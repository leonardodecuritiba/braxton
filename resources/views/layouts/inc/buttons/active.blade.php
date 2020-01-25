@if(Entrust::can($sel['entity'] . '.active'))
    <a class="btn btn-simple btn-{{$active['active_btn_color']}} btn-xs btn-icon active"
        data-model="{{$active['model']}}"
        data-id="{{$active['id']}}">
        <i class="material-icons">{{$active['active_btn_icon']}}</i></a>
@endif