@if($Data->active)
    <div class="alert alert-success">
        {{trans('global.Active.'.$Page->sex,['name' => $Page->name])}}
    </div>
@else
    <div class="alert alert-danger">
        {{trans('global.Inactive.'.$Page->sex,['name' => $Page->name])}}
    </div>
@endif
