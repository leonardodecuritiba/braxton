<script>
    function getAjaxSensors($this, $this_child, value_child = ""){
        var text_child = 'Escolha o Sensor';

        $($this_child).empty();
        $($this_child).append("<option value=''>" + text_child + "</option>");
        $($this_child).val('').change().selectpicker('render');

        if ($($this).val() == "") {
            return false;
        }
        $.ajax({
            url: '{{route('ajax.get.device-sensors')}}',
            data: {id: $($this).val()},
            type: 'GET',
//                    dataType: "json",
            beforeSend: function (xhr, textStatus) {
                loadingCard('show', $this);
            },
            error: function (xhr, textStatus) {
                console.log('xhr-error: ' + xhr.responseText);
                console.log('textStatus-error: ' + textStatus);
                loadingCard('hide', $this);
            },
            success: function (json) {
                console.log(json);
                $(json).each(function (i, v) {
                    $($this_child).append('<option value="' + v.id + '">' + v.text + '</option>')
                });
                $($this_child).selectpicker("refresh");
                if(value_child!=""){
                    $($this_child).val(value_child).trigger('change');
                }
                $_LOADING_.waitMe('hide');
            }
        });
    }
    $(document).ready(function () {
        $($_INPUT_DEVICE_).selectpicker();
        $($_INPUT_SENSOR_).selectpicker();

        //CHANGING UNIT - FILL JOBS
        $($_INPUT_DEVICE_).change(function () {
            getAjaxSensors($_INPUT_DEVICE_, $_INPUT_SENSOR_);
        });
    })
</script>