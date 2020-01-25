
{{--{{Html::script('bower_components/adminbsb-materialdesign/plugins/jquery-validation/jquery.validate.js')}}--}}
{{Html::script('bower_components/jquery-validation/dist/jquery.validate.min.js')}}
<script>
    $(function () {
        $('#form_validation').validate({
            rules: {
                'checkbox': {
                    required: true
                },
                'gender': {
                    required: true
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });
    });
</script>